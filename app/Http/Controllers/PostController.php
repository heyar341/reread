<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\PostRequest;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all()->latest()->pagenate(9);
        return view('posts.index')->with($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //本の情報
        //Google Books APIの書籍id(bookCode)でDB内に一致するレコードがあるかチェック。なければインスタンス生成。
        if (is_null(Book::query()->where('bookCode')->first())) {
            //インスタンス生成
            $book = new Book();
            $book->bookCode = $request->bookCode;
            $book->title = $request->title;
            $book->infoLink = $request->infoLink;
            $book->authors = $request->authors;
            $book->publishedDate = $request->publishedDate;
            $book->pageCount = $request->pageCount;
            $book->description = $request->description;
            $book->bookThumbnail = $request->thumbnail;
            $book->save();
        } //すでに書籍情報があれば、その書籍を参照
        else {
            $book = Book::query()->where('bookCode')->first();
        }


//        投稿情報
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->thumbnail_comment = $request->thumbnail_comment;
        $post->main_content = Purifier::clean($request->main_content);
        $post->post_state = $request->post_state;
        //書籍のid取得
        $post->book_id = $book->id;
        $post->save();


        return redirect('/')->with('success', '投稿しました!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //書籍情報を取得
        $book = Book::find($post->book_id);

        //非公開、下書きは表示しない。
        if ($post->post_state == 2 || $post->post_state == 3) {
            if (auth()->user()->id == $post->user_id) {
                return view('posts.show', compact('post', 'book'));
            } else {
                return redirect('/')->with('danger', 'アクセスした投稿は非公開の投稿のため、ご覧になることはできません。');
            }
        }

        //post_state=1の時の処理
        //アクセス時、閲覧数カウントを追加
        if (auth()->user()->id == $post->user_id) {
            return view('posts.show', compact('post', 'book'));
        }
        else {
            $post->increment('viewed_count', 1);
            //update時順に並べる際に整合性を保つため、timestampは無効にする
            $post->timestamps = false;
            $post->save();
            return view('posts.show', compact('post', 'book'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->thumbnail_comment = $request->input('thumbnail_comment');
        $post->main_content = Purifier::clean($request->input('main_content'));
        $post->post_state = $request->input('post_state');

        $post->save();

        return redirect("/post/{$post->id}")->with('success', '更新しました!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/')->with('success', '投稿を削除しました!');
    }
}
