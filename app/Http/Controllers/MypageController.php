<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    //マイページ画面の表示
    public function home(User $user)
    {
        return view('mypage.home', compact('user'));
    }

    //投稿一覧表示
    public function index(User $user, $post_state)
    {
        //投稿状態に応じて、投稿データ取得
        $posts = $user->posts()->with(['book', 'is_liked', 'user.profile.followers'])->
        where('post_state', $post_state)->latest()->paginate(6);

        //投稿状態に応じて、表示内容変更
        if ($post_state == 1) {
            $title = "公開済みの投稿";
        }
        elseif ($post_state == 2) {
            $title = "非公開の投稿";
        }
        elseif ($post_state == 3) {
            $title = "下書きの投稿";
        }
        return view('mypage.postshow', compact('posts', 'user', 'title'));
    }

    //全ての投稿表示
    public function showall(User $user)
    {
        $posts = $user->posts()->with(['book', 'is_liked', 'user.profile.followers'])
            ->latest()->paginate(6);
        $title = "全ての投稿一覧";
        return view('mypage.postshow', compact('posts', 'user', 'title'));
    }

    //フォローしたユーザー一覧表示
    public function follow(User $user)
    {
        //フォローしているユーザーを取得
        $follows = $user->following()->with('user')->get();
        return view('mypage.follow', compact('follows'));
    }

    //フォロワーユーザー一覧表示
    public function follower(User $user)
    {
        //フォロワーユーザーを取得
        $followers = $user->profile->followers()->with('profile')->get();
        return view('mypage.follower', compact('followers'));
    }

    //お気に入り投稿一覧表示
    public function favorite(User $user)
    {
        //お気に入り投稿がなかった場合
        if (count($user->likes()->get()) == 0) {
            $posts = 0;
        }
        else {
            $posts = $user->likes()->with(['book', 'is_liked', 'user.profile.followers'])
                ->latest()->paginate(6);
        }
        $title = "お気に入り一覧";
        return view('mypage.favorite', compact('posts', 'title'));
    }

    //ユーザーアカウント削除確認
    public function predelete(User $user)
    {
        return view("mypage.confirm_delete", compact('user'));
    }

    //ユーザーアカウント削除
    public function delete(User $user)
    {
        if ($user->likes()) {
            $user->likes()->detach();
        }
        if ($user->following()) {
            $user->following()->detach();
        }
        if ($user->profile->followers()) {
            $user->profile->followers()->detach();
        }
        if ($user->posts()) {
            $posts = $user->posts();
            foreach ($posts as $post) {
                if (!empty($post->is_liked()->first())) {
                    $user->posts->is_liked()->detach();
                }
                $post->book()->detach();
            }
            $user->posts()->delete();
        }
        $user->profile()->delete();
        $user->delete();
        return redirect('/')->with('success', 'ユーザーアカウントを削除しました !');
    }
}
