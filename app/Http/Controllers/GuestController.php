<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Photo;
use App\Models\User;
use App\Models\Ai_service;

class GuestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return inertia('Guest/Posts', [
            'photos' => Photo::orderByDesc('id')->with(['user' => function ($query) {
                $query->select('id', 'name', 'profile_photo_path');
            }])->with('ai_service')->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function redirect()
    {
        return redirect('/allposts');
    }

    public function userPosts($uid)
    {

        $photos = Photo::orderByDesc('id')->where('user_id', $uid)->with(['user' => function ($query) {
            $query->select('id', 'name', 'profile_photo_path');
        }])->with('ai_service')->get();

        if ($photos->isEmpty()) {
            $singleUser = User::select('id', 'name', 'profile_photo_path')->where('id', $uid)->get();
           
            if ($singleUser->isEmpty()) {
                abort(404);
            }

            return inertia('Guest/Posts', [
                'singleUser' => $singleUser[0],
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        }

        return inertia('Guest/Posts', [
            'photos' => $photos,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'singleUser' => $photos[0]->user,
        ]);
    }

    public function aiService($aiService)
    {

        $photos = Photo::orderByDesc('created_at')
            ->where('ai_service_id', $aiService)
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'profile_photo_path');
            }])->with('ai_service')->get();

        if ($photos->isEmpty()) {
            $singleAi = Ai_service::select('id', 'name', 'url')->where('id', $aiService)->get();
            
            if (is_null($singleAi)) {
                abort(404);
            }
            return inertia('Guest/Posts', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'singleAi'  => $singleAi[0],
            ]);
        }

        return inertia('Guest/Posts', [
            'photos' => $photos,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'singleAi' => $photos[0]->ai_service,
        ]);
    }
}
