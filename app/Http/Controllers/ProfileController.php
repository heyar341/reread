<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\ProfileRequest;
use App\Post;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->profile->id) : false;
        $posts = Post::with(['book', 'is_liked'])
            ->where('user_id', $user->id)
            ->where('post_state', 1)
            ->latest()->paginate(6);
        return view('profiles.index', compact('user', 'posts', 'follows'));
    }

    public function edit(User $user)
    {
        return view('profiles.edit', compact('user'));
    }

    public function update(ProfileRequest $request, User $user)
    {
        $profile = auth()->user()->profile;
        //自己紹介
        //文字が空の場合
        if (empty($request->input('intro_self'))) {
            $profile->intro_self = 'Not Edited';
        }
        else {
            $profile->intro_self = $request->input('intro_self');
        }

        //ユーザーのサイトURL
        //URLが空の場合
        if (empty($request->input('prof_url'))) {
            $profile->prof_url = 'Not Edited';
        }
        else {
            $profile->prof_url = $request->input('prof_url');
        }

        //プロフィール画像
        //画像を変更しない場合は何もしない
        if ($request->prof_image === 'no') {
        }
        //ユーザーがデフォルトから変更後、もう一度デフォルトに戻る場合
        elseif ($request->prof_image === 'default-image/profile_image_default.png') {
            $profile->prof_image = $request->prof_image;
        }
        //画像を変更する場合
        else {
            $disk = Storage::disk('s3');
            if ($profile->prof_image != 'default-image/profile_image_default.png' && $disk->exists($profile->prof_image)) {
                $disk->delete($user->profile->prof_image);
            }
            //画像ファイルを変数に取り込む
            $imagefile = $request->file('prof_image');
            //画像の保存先パスを取得
            $storagePath = $imagefile->store('profile_image', 's3');
            $image = Image::make($imagefile)->fit(300, 300);
            $disk->put($storagePath, (string)$image->encode());

            $profile->prof_image = $storagePath;

        }
        $profile->save();
        return redirect("/mypage/{$user->id}");
    }
}
