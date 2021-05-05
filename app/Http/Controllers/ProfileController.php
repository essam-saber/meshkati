<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();
        return view('pages.profile.index')->with([
            'page_title' => $user->name.'\'s profile',
            'user' => $user
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->all();
        if($oldPassword = $data['old_password']) {
            if(auth()->attempt(['email' => auth()->user()->email, 'password' => $oldPassword])) {
                $data['password'] = bcrypt($data['password']);
            }
        }

        auth()->user()->update($data);
        return back()->with(['success' => 'Your account information has been updated successfully']);
    }
}
