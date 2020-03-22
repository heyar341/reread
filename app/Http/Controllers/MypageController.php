<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  \App\User  $user
     * @param string $post_state
     * @return \Illuminate\Http\Response
     */
    public function index(User $user,$post_state ){
        //投稿したユーザーのみ閲覧可能
        if(auth()->user()->id == $user->id) {
            if ($post_state == 1) {
                $posts = $user->posts()->where('post_state', 1)->get();
                return view('mypage', compact('posts'))->with(['title' => '公開中の投稿']);

            }
            if ($post_state == 2) {
                $posts = $user->posts()->where('post_state', 2)->get();
                return view('mypage', compact('posts'))->with(['title' => '非公開の投稿']);

            }
            if ($post_state == 3) {
                $posts = $user->posts()->where('post_state', 3)->get();
                return view('mypage', compact('posts'))->with(['title' => '下書きの投稿']);

            }
            else{
                return redirect('/')->with('error','URLが無効です。');
            }
        }

        //投稿したユーザー以外は、はじかれる
        else{
            return redirect('/')->with('error','アクセス権限がありません');
        }
    }
}
