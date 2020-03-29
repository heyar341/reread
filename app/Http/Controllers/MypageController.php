<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(User $user){
        return view('mypage.home',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\User  $user
     * @param string $post_state
     * @return \Illuminate\Http\Response
     */
    public function index(User $user,$post_state){
        //投稿したユーザーのみ閲覧可能
        if(!Auth::check()){
            return redirect('/')->with('error','アクセス権限がありません');
        }


        if(auth()->user()->id == $user->id) {
            //投稿状態に応じて、投稿データ取得
            $posts = $user->posts()->with(['book','is_liked','user.profile.followers'])->where('post_state', $post_state)->latest()->paginate(6);

            //投稿状態に応じて、表示内容変更
            if ($post_state == 1) {
                $title = "公開済みの投稿";
            }
            if ($post_state == 2) {
                $title = "非公開の投稿";
            }
            if ($post_state == 3) {
                $title = "下書きの投稿";
            }
            return view('mypage.postshow', compact('posts', 'user', 'title'));
        }

        //URLで４とか入ってたら無効
        else{
                return redirect('/')->with('error','URLが無効です。');
            }
    }

    public function showall(User $user)
    {
        //投稿したユーザーのみ閲覧可能
        if (!Auth::check()) {
            return redirect('/')->with('error', 'アクセス権限がありません');
        }
        if(auth()->user()->id == $user->id) {
            //投稿状態に応じて、投稿データ取得
            $posts = $user->posts()->with(['book', 'is_liked', 'user.profile.followers'])->latest()->paginate(6);

            $title = "全ての投稿一覧";
            return view('mypage.postshow', compact('posts', 'user', 'title'));
        }
        else{
            return redirect('/')->with('error','他のユーザーのページです。');

        }
    }

    public function follow(User $user)
    {
        //ログインユーザーのみ閲覧可能
        if (!Auth::check()) {
            return redirect('/')->with('error', 'アクセス権限がありません');
        }
        if(auth()->user()->id == $user->id) {
            //投稿状態に応じて、投稿データ取得
            $follows = $user->following()->with('user')->get();
//            $follows = User::where('user_id',$user_ids)->get();
//            dd($follows);

            return view('mypage.follow', compact('follows'));
        }
        else {
            return redirect('/')->with('error','他のユーザーのページです。');
        }
    }

    public function follower(User $user)
    {
        //ログインユーザーのみ閲覧可能
        if (!Auth::check()) {
            return redirect('/')->with('error', 'アクセス権限がありません');
        }
        if(auth()->user()->id == $user->id) {
            //投稿状態に応じて、投稿データ取得
            $followers = $user->profile->followers()->with('profile')->get();

//            dd($follower);
            $title = "フォロワー";
            return view('mypage.follower', compact('followers','title'));
        }
        else {
            return redirect('/')->with('error','他のユーザーのページです。');
        }
    }
}
