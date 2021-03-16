<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login')->with([
            'page_title' => 'Login To Meshkati Administrator Area'
        ]);
    }

    public function postLogin(Request $request)
    {
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        }
       auth()->logout();
        return back()->with(['invalid' => 'Invalid Credentials !']);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
