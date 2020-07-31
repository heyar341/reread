<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user){
            $user->profile()->create([
                'intro_self' => 'Not Edited',
                'prof_url' => 'Not Edited',
                'prof_image' => 'default-image/profile_image_default.png',
            ]);
        });
    }

//Profile関連
//　Userが持つprofile
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
//  Userがfollowする
    public function following()
    {
        return $this->belongsToMany('App\Profile');
    }

//Post関連
//  Userが投稿する
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
//  Userがお気に入りに追加する
    public function likes()
    {
        return $this->belongsToMany('App\Post');
    }

}
