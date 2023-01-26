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
        $contents = file_get_contents($url);

        $path = Storage::disk('s3')->put('photos', $contents);
        $path = Storage::disk('s3')->url($path);
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
