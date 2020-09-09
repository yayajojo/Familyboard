<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        return view('profiles.create', ['user' => Auth::user()]);
    }

    public function store(Request $request)
    {

        $validatedUserInfo = $this->validateUserInfo($request);
        Auth::user()->update($validatedUserInfo);
        if ($request->exists('avatar')) {
            $this->validateAvatar($request);
            $storageAvatar = request('avatar')->store('public/avatars');
            $publicAvatar = str_replace('public','/storage',$storageAvatar);
            Profile::updateOrCreate(
                ['user_id' => Auth::id()],
                ['avatar'=>$publicAvatar]
            );
        };
            return redirect(route('project.index'));
    }

    public function validateUserInfo(Request $request)
    {
        return $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required','min:8', 'confirmed']
        ]);
    }

    public function validateAvatar(Request $request)
    {
        return $request->validate([
            'avatar' => ['file']
        ]);
    }
}
