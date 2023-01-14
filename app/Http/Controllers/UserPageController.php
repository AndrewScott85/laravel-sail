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
            }])->get()
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


}
