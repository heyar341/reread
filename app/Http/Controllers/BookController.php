<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class BookController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

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
        $json_decoded_results = json_decode($books_result,true);
        //paginate()はDBに対してのメソッドだから使えない
        $books = $json_decoded_results['items'];

        //各要素が空の場合の処理
        for($i=0;$i<10;$i++){
            if(empty($books[$i]['volumeInfo']['imageLinks']['thumbnail'])){
                $books[$i]['volumeInfo']['imageLinks']['thumbnail'] = Config::get('app.profile_image_url')."default-image/no_image_avairable.png";
            }
             if(empty($books[$i]['volumeInfo']['authors'])){
                 $books[$i]['volumeInfo']['authors'][0] = "不明";
             }
             if(empty($books[$i]['volumeInfo']['publishedDate'])){
                 $books[$i]['volumeInfo']['publishedDate'] = "不明";
             }
             if(empty($books[$i]['volumeInfo']['pageCount'])){
                 $books[$i]['volumeInfo']['pageCount'] = "不明";
             }
             if(empty($books[$i]['volumeInfo']['description'])){
                 $books[$i]['volumeInfo']['description'] = "･･･";
             }
        }

//        dd($books);
        return view('book.show',compact('books','book_name_base'));
    }

    public function create(Request $request)
    {
        $book = $request->all();
//        Eloquentじゃないから、アローで値を取り出すのではなく、配列として取り出す必要がある。
        return view('posts.create',compact('book'));
    }
}
