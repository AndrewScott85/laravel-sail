<?php
namespace App\Services;

class OpenAIService
{

    public function generateDescription($validatedData)
    {
        $prompt = $validatedData['prompt'];
        $title = $validatedData['title'];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
              "model": "text-davinci-001",
              "prompt": "write a short story, article or blog post, of at least 500 characters using the following title: '.$title.' and prompt: '.$prompt.'. You can ignore any words which are not found in the dictionary",
              "temperature": 0.4,
              "max_tokens": 500,
              "top_p": 1,
              "frequency_penalty": 0,
              "presence_penalty": 0
            }',
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer ". env('OPEN_AI_KEY'),
            ],
        ]);
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }

    public function generateImage($validatedData)
    {
        $prompt = $validatedData;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.openai.com/v1/images/generations",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                "prompt": "'.$prompt.'",
                "n": 1,
                "size": "1024x1024"
              }',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer " . env('OPEN_AI_KEY')
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
}
