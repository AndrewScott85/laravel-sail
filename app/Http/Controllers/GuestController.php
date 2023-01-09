<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Photo;

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
        $singleUser = false;
        return inertia('Guest/Posts', [
            'photos' => Photo::orderByDesc('id')->with('user')->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'singleUser' => $singleUser
        ]);
    }

    public function redirect()
    {
        return redirect('/allposts');
    }

    public function userPosts($uid)
    {
        $singleUser = true;
        return inertia('Guest/Posts', [
            'photos' => Photo::orderByDesc('id')->where('user_id', $uid)->with('user')->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'singleUser' => $singleUser
        ]);
    }
}
