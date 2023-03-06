<?php

namespace App\Http\Controllers;

use App\Models\Ai_service;
use Illuminate\Http\Request;
use App\Models\Photo;

class UserPageController extends Controller
{
    public function displayAllEditable()
    {
        $uid = auth()->id();
        return inertia('User/Posts', [
            'photos' => Photo::orderByDesc('id')->where('user_id', $uid)->with(['user' => function ($query) {
                $query->select('id', 'name');
            }])->with('ai_service')->get()
        ]);
    }

    public function create()
    {
        return inertia('User/PhotoCreate', ['ai_services' => Ai_service::orderByDesc('name')->get()]);
    }

    public function edit(Photo $photo)
    {
            if ($photo->user->id == auth()->id()) {
                return inertia('User/PhotoEdit', [
                    'photo' => $photo,
                    'ai_services' => Ai_service::orderByDesc('name')->get()
                ]);
            } else {
                return to_route('user.manageposts');
            }
    }

    public function openaiCreate()
    {
        return inertia('User/OpenAICreate');
    }

    public function openaiReview()
    {
        $description = session()->get('description');
        $image = session()->get('image');
        $title = session()->get('title');
        $newDesc = session()->get('newDesc', null);
        $newImage = session()->get('newImage', null);
    
        return inertia('User/OpenAIReview', [
            'description' => $description,
            'image' => $image,
            'title' => $title,
            'newDesc' => $newDesc,
            'newImage' => $newImage,
        ]);
    }
    
}
