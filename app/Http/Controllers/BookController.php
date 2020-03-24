<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function search()
    {
        return view('book.search');
    }

    public function show(Request $request){
        $book_name = $request->book;
        $search_url = "https://www.googleapis.com/books/v1/volumes?q=".$book_name."&maxResults=10&startIndex=0";
        $books_result = file_get_contents($search_url);
        $json_decoded_results = json_decode($books_result);
        //paginate()はDBに対してのメソッドだから使えない
        $books = $json_decoded_results->items;
//        dd($books);


        return view('book.show',compact('books'));
    }
}
