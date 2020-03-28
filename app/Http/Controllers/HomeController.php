<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
    {
        $posts = Post::latest()->paginate(6);
            return view('home', compact('posts'));
    }
}
