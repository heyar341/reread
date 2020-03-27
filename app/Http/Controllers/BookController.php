<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function search()
    {
        return view('book.search');
    }

    public function show(BookRequest $request){
        $book_name_base = $request->bookName;
        //半角の空白を+に置換
        $book_name_remove_empty1 = str_replace(" ",'+',$book_name_base);
        //全角のスペースを+に置換
        $book_name = str_replace("　",'+',$book_name_remove_empty1);
        $search_url = "https://www.googleapis.com/books/v1/volumes?q=".$book_name."&maxResults=10&startIndex=0";
        $books_result = file_get_contents($search_url);
        $json_decoded_results = json_decode($books_result);
        //paginate()はDBに対してのメソッドだから使えない
        $books = $json_decoded_results->items;
//        dd($books);


        return view('book.show',compact('books','book_name_base'));
    }

    public function create(Request $request)
    {
        $book = $request->all();
//        Eloquentじゃないから、アローで値を取り出すのではなく、配列として取り出す必要がある。
//        dd($book['title']);
        return view('posts.create',compact('book'));
    }
}
