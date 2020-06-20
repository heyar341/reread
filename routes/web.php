<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');
Route::get('/today','HomeController@today');
Route::get('/popular','HomeController@popular');

Auth::routes();

//Follow用ルート
Route::post('follow/{user}','FollowsController@store');

//お気に入り用ルート
Route::post('favorite/{post}','FavoriteController@store');


//Profile用ルート
Route::get('profile/{user}','ProfileController@index');
Route::get('profile/{user}/edit','ProfileController@edit');
Route::patch('profile/{user}','ProfileController@update');

//Post用ルート
Route::resource('post','PostController');
Route::post('post/search','PostController@search');

//Mypage用ルート
//authミドルウェアでログイン中か確認し、check_login_userミドルウェアでログイン中のユーザーのページか確認。
Route::middleware(['auth','check_login_user'])->group(function () {
    Route::get('mypage/favorite/{user}', 'MypageController@favorite')->where('user', '[0-9]+');
    Route::get('mypage/{user}/postshow', 'MypageController@showall')->where('user', '[0-9]+');
    Route::get('follow/{user}/show', 'MypageController@follow')->where('user', '[0-9]+');
    Route::get('follower/{user}/show', 'MypageController@follower')->where('user', '[0-9]+');
    Route::get('mypage/{user}/delete_confirm', 'MypageController@predelete')->where('user', '[0-9]+');
    Route::post('mypage/{user}/delete', 'MypageController@delete')->where('user', '[0-9]+');
    Route::get('mypage/{user}/{post_state}', 'MypageController@index')->where(['user'=>'[0-9]+','post_state'=>'[1-3]+']);
    Route::get('mypage/{user}', 'MypageController@home')->where('user', '[0-9]+');
});
//本の検索用
Route::get('search_book','BookController@search');
Route::post('search','BookController@show');
Route::post('post/create','BookController@create');

