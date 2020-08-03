<?php

namespace App\Http\Controllers;

use App\Book;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user_info = auth()->user()->id ?? 'guest';
        Log::info($user_info . ' accessed ' . url()->current() .' at ' . Carbon::now() .' IP: ' . $request->ip()/**$_SERVER["HTTP_X_FORWARDED_FOR"]*/);

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
            ->where('post_state',1)
            ->withCount('is_liked')
            ->orderBy('is_liked_count','desc')
            ->paginate(6);

        $title = "お気に入りが多い投稿";

        return view('home.home', compact('posts','title'));
    }

    public function searchPost(Request $request)
    {
        $books = Book::query()->where('title','like','%'.$request->query_text.'%')->get();

        $posts = [];
        $title = "お探しの書籍の投稿はありません。";

        //検索結果があった場合
        if(count($books) > 0) {
            //検索条件に一致したBookのidを配列に入れる
            $books_id = [];
            foreach ($books as $book) {
                array_push($books_id, $book->id);
            }
            //book_idに入ったidに一致する投稿を取得
            $posts = Post::with(['book', 'is_liked', 'user.profile.followers'])
                ->whereIn('book_id', $books_id)
                ->where('post_state', 1)
                ->latest()
                ->paginate(6);
            $title = "検索結果";
        }

        return view('home.home', compact('posts','title'));
    }

}
