<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\ProfileRequest;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('profiles.index',compact('user'));
    }

    public function edit(User $user)
    {

        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));

    }

    public function update(ProfileRequest $request, User $user)
    {
        $profile = auth()->user()->profile;

        if(empty($request->input('intro_self'))){
            $profile->intro_self = 'Not Edited';
        }
        else {
            $profile->intro_self = $request->input('intro_self');
        }
        if(empty($request->input('prof_url'))){
            $profile->prof_url = 'Not Edited';
        }
        else {
            $profile->prof_url = $request->input('prof_url');
        }

        if($request->prof_image){
            //画像ファイルを変数に取り込む
            $imagefile = $request->file('prof_image');
            //画像の保存先パスを取得
            $storagePath=$imagefile->store('uploads/profile_image','s3');
            $image = Image::make($imagefile)->fit(300,300);
            Storage::disk('s3')->put($storagePath, (string) $image->encode(),'public');


            //本番環境ではs3のバケットに合わせて変える
            $profile->prof_image = "http://localhost:60007/test/".$storagePath;
        }

        $profile->save();
        return redirect("/profile/{$user->id}");
    }
}
