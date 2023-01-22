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
        if (auth()->id() != 1 && auth()->id() != 2) {
            $validatedData = $this->validate($request, [
                'prompt' => ['required'],
                'title' => ['required'],
            ]);

            $description = $this->openAIService->generateDescription($validatedData);
            $image = $this->openAIService->generateImage($validatedData['prompt']);
        return inertia('User/OpenAI', [
            'description' => $description,
            'image' => $image
        ]);
    }
    }

}
