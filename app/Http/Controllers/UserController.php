<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class UserController extends Controller
{
    public function userPosts($uid)
    {
        // dd($uid);
        return inertia('User/Posts', [
            'photos' => Photo::orderByDesc('id')->where('user_id', $uid)->with('user')->get()
        ]);
    }

    public function create()
    {
        return inertia('User/PhotoCreate');
    }

    public function post()
    {
        $validated_data = Request::validate([
             'path' => ['required', 'image', 'max:2000'],
             'description' => ['required'],
             'title' => ['required'],
        ]);
         $path = Storage::disk('s3')->put('photos', Request::file('path'));
         $path = Storage::disk('s3')->url($path);
         $validated_data['path'] = $path;
         $validated_data['user_id'] = Auth::id();
         Photo::create($validated_data);
         return to_route('user.posts');
 
     }
}
