<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['book','isLiked','user'=>
            function($query){$query->with(['profile'=>
                function($query){$query->with('followers');}]);}])->where('post_state',1)->latest()->paginate(6);
        return view('home', compact('posts'));
    }
}
