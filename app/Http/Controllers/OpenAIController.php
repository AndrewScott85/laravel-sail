<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use App\Services\OpenAIService;

class OpenAIController extends Controller
{

    private $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function openaiPost(Request $request)
    {
                $user = hash("sha256", auth()->user()->name);

                $validatedData = $this->validate($request, [
                'prompt' => ['required'],
                'title' => ['required', 'max:30', 'string'],
                'text' => ['required', 'max:30', 'string'],
                'style' => ['required', 'max:30', 'string'],
            ]);

            $moderation = $this->openAIService->moderateInput($validatedData, $user);
            
            if (!$moderation->results[0]->flagged) {
            $description = $this->openAIService->generateDescription($validatedData, $user);
            $image = $this->openAIService->generateImage($validatedData['prompt'], $user);
        return redirect(route('user.openai.review'))->with([
            'moderation' => $moderation,
            'description' => $description,
            'image' => $image,
            'title' => $validatedData['title']
        ]);
    } else {
        return inertia('User/OpenAICreate', [
            'flagged' => 'Your title or prompt has failed automatic content moderation, please
             consult the OpenAI moderation guidelines and try again.'
        ]);
    }
}

public function openaiStore(Request $request)
{
    if (auth()->id() != 1 && auth()->id() != 2) {
        $url = $request->url;

        $mime = "image/png";
        $filename = $request->name;
        $output = new \CURLFile($url, $mime, $filename);
        $data = ["files" => $output];
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=90');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = curl_error($ch);
        }
        curl_close($ch);
 
        $arrResult = json_decode($result);
 
        // store the optimized version of the image
        $ch = curl_init($arrResult->dest);
        $fp = fopen($filename, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        $path = Storage::disk('s3')->put('photos/'.$filename, file_get_contents($filename));
        $path = Storage::disk('s3')->url('photos/'.$filename);
        $validatedData['path'] = $path;
        $validatedData['user_id'] = auth()->id();
        $validatedData['title'] = $request->title;
        $validatedData['description'] = $request->description;
        $validatedData['ai_service_id'] = 2;
        Photo::create($validatedData);
        return to_route('user.manageposts');
    }
   
}

// public function editImage(Request $request)
//     {
//             $validatedData = $this->validate($request, [
//                 'prompt' => ['required'],
//                 'title' => ['required', 'max:30', 'string'],
//                 'style' => ['required', 'max:30', 'string'],
//             ]);

//             $moderation = $this->openAIService->moderateInput($validatedData);
            
//             if (!$moderation->results[0]->flagged) {
//             $description = $this->openAIService->generateDescription($validatedData);
//             $image = $this->openAIService->generateImage($validatedData['prompt']);
//         return inertia('User/OpenAICreate', [
//             'moderation' => $moderation,
//             'description' => $description,
//             'image' => $image
//         ]);
//     } else {
//         return inertia('User/OpenAI', [
//             'flagged' => 'Your title or prompt has failed automatic content moderation, please try again.
//              If you do not know why your input generated this response, please consult the OpenAI moderation guidelines'
//         ]);
//     }
// }

}
