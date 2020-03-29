<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function index()
    {
        //読みにくいので没
//        $posts = Post::with(['book','isLiked','user'=>
//            function($query){$query->with(['profile'=>
//                function($query){$query->with('followers');}
//                ]);}])->where('post_state',1)->latest()->paginate(6);
        //クエリー発行数を減らすため、まとめて取得
        $posts = Post::with(['book','is_liked','user.profile.followers'])
            ->where('post_state',1)
            ->latest()->paginate(6);

        $title = "投稿一覧";

        return view('home.home', compact('posts','title'));
    }

    public function today()
    {
        //whereDateメソッドとCarbonでで日付一致
        $posts = Post::with(['book','is_liked','user.profile.followers'])
            ->where('post_state',1)
            ->whereDate('created_at',Carbon::today())
            ->latest()->paginate(6);

        $title = "今日の投稿";

        return view('home.home', compact('posts','title'));
    }

    public function popular()
    {
        //withCountメソッドとorderByメソッドでお気に入りが多い順に並べ替え
        $posts = Post::with(['book','is_liked','user.profile.followers'])
            ->withCount('is_liked')->orderBy('is_liked_count','desc')
            ->where('post_state',1)->paginate(6);

        $title = "お気に入りが多い投稿";

        return view('home.home', compact('posts','title'));
    }
}
