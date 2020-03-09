<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);

        return view('profiles.index',compact(['user',]));

    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);

        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));

    }
}
