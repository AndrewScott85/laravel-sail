<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = [
            'email' => 'lane44@example.com',
            'password' => 'password',
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/allposts');
        } else {
            return redirect()->back()->withErrors(['message' => 'Invalid Credentials - Please check with system administrator']);
        }
    }

}
