<?php
namespace App\Services;

class OpenAIService
{

    public function moderateInput($validatedData, $user)
    {
        $input = implode('. ', $validatedData);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/moderations",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
             "input" : "'.$input.'",
             "user" : "'.$user.'"
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

    public function generateDescription($validatedData, $user)
    {
        // $prompt = $validatedData['prompt'];
        $title = $validatedData['title'];
        $text = $validatedData['text'];

        $curl = curl_init();
        $messages = array(
        ["role" => "system", "content" => "you are a highly intelligent, capable, and helpful AI text generator."],
        ["role" => "user", "content" => "I have an image with title $title, please can you write $text to accompany it"],
        );

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
              "model" => "gpt-3.5-turbo",
              "messages" => $messages,
            //   "you are a highly intelligent, capable, and helpful AI text generator. "
            //   . "The user has generated an image with OpenAI which has a title of $title. "
            //   . "For context only, the image was created from the prompt $prompt. "
            //   . "Do not write anything using the words in the image prompt. "
            //   . "Write a text from the prompt: $text to accompany this image",
              "temperature" => 0.25,
              "max_tokens" => 600,
              "top_p" => 1,
              "frequency_penalty" => 0.5,
              "presence_penalty" => 0.5,
              "user" => $user
            ]),
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

    public function editDescription($validatedData)
    {
        $text = $validatedData['text'];
        $instruction = $validatedData['instruction'];
 
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openai.com/v1/edits",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
              "model" => "text-davinci-edit-001",
              "input" => $text,
              "instruction" => $instruction,
            ]),
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

    public function generateImage($validatedData, $user)
    {
        $prompt = $validatedData;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.openai.com/v1/images/generations",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => '{
                "prompt": "'.$prompt.'",
                "n": 1,
                "size": "1024x1024",
                "user": "'.$user.'"
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

    public function editImage($im, $prompt, $user)
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.openai.com/v1/images/edits",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                "image" => $im,
                "prompt" => $prompt,
                "n" => 1,
                "size" => "512x512",
                "user" => $user
            ),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: multipart/form-data",
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
    


    public function variationImage($im, $user)
    {
        $curl = curl_init();
        $cfile = curl_file_create($im);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.openai.com/v1/images/variations",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 180,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(
                "image" => $cfile,
                "n" => 1,
                "size" => "1024x1024",
                "user" => $user
            ),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: multipart/form-data",
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
