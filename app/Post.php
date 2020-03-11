<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded =[];


//  投稿するUserとの関係
    public function user()
    {
        return $this->belongsTo('App\User');
    }

//  お気に入り押したUserとの関係
    public function isLiked()
    {
        return $this->belongsToMany('App\User');
    }
}
