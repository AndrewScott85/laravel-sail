<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function displayAllEditable()
    {
        $uid = auth()->id();
        return inertia('User/Posts', [
            'photos' => Photo::orderByDesc('id')->where('user_id', $uid)->with('user')->get()
        ]);
    }

    public function create()
    {
        return inertia('User/PhotoCreate');
    }

    public function post(Request $request)
    {
        $validatedData = $this->validate($request, [
             'path' => ['required', 'image', 'max:2000'],
             'description' => ['required'],
             'title' => ['required'],
        ]);
         $path = Storage::disk('s3')->put('photos', $request->file('path'));
         $path = Storage::disk('s3')->url($path);
         $validatedData['path'] = $path;
         $validatedData['user_id'] = auth()->id();
         Photo::create($validatedData);
         return to_route('user.manageposts');
 
     }

    public function edit(Photo $photo)
    {
        if ($photo->user->id == auth()->id()){
        return inertia('User/PhotoEdit', [
            'photo' => $photo
        ]);
    } else {
        return to_route('user.manageposts');
    }
}

    public function update(Photo $photo, Request $request)
    {
    $validatedData = $request->validate([
        'description' => ['required'],
        'title' => ['required']
   ]);

    if ($request->hasFile('path')) {
        $validatedData['path'] = $request->validate([
            'path' => ['required', 'image', 'max:2000'],
        ]);

//Grab old image and delete it
    $oldImage = $photo->path;
    Storage::delete($oldImage);

    $path = Storage::disk('s3')->put('photos', $request->file('path'));
    $path = Storage::disk('s3')->url($path);
    $validatedData['path'] = $path;
}

$photo->update($validatedData);
    return to_route('user.manageposts');

}

public function delete(Photo $photo)
{
    if ($photo->user->id == auth()->id()) {
    Storage::delete($photo->path);
    $photo->delete();
    return to_route('user.manageposts');
    }
}

}
