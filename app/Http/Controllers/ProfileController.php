<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\ProfileRequest;
use App\Profile;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(User $user)
    {

        return view('profiles.index',compact(['user',]));

    }

    public function edit(User $user)
    {

        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));

    }

    public function update(ProfileRequest $request, User $user)
    {
        $profile = auth()->user()->profile;

        $profile->intro_self = $request->input('intro_self');
        $profile->prof_url = $request->input('prof_url');
        $profile->prof_image = $request->input('prof_image');

        auth()->user()->profile->save();

        return redirect("/profile/{$user->id}");
    }
}
