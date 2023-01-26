<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function post(Request $request)
    {
        dd($request);
        if (auth()->id() != 1 && auth()->id() != 2) {
            $validatedData = $this->validate($request, [
                'path' => ['required', 'image', 'max:2000'],
                'description' => ['required'],
                'title' => ['required'],
                'ai_service_id' => ['required']
            ]);
            $path = Storage::disk('s3')->put('photos', $request->file('path'));
            $path = Storage::disk('s3')->url($path);
            $validatedData['path'] = $path;
            $validatedData['user_id'] = auth()->id();
            Photo::create($validatedData);
            return to_route('user.manageposts');
        }
    }

    public function update(Photo $photo, Request $request)
    {
        if (auth()->id() != 1 && auth()->id() != 2) {
            $validatedData = $request->validate([
                'description' => ['required'],
                'title' => ['required'],
                'ai_service_id' => ['required']
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
        
    }

    public function delete(Photo $photo)
    {
        if (auth()->id() != 1 && auth()->id() != 2) {
            if ($photo->user->id == auth()->id()) {
                Storage::delete($photo->path);
                $photo->delete();
                return to_route('user.manageposts');
            }
        }
    }

}
