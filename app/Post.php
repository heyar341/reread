<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded =[];


    //投稿するUserとの関係
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //投稿の書籍との関係
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    //お気に入り押したUserとの関係
    public function is_liked()
    {
        return $this->belongsToMany('App\User');
    }
}
