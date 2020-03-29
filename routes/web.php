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
Route::get('mypage/{user}/{post_state}','MypageController@index');
Route::get('mypage/{user}','MypageController@home');

//本の検索用
Route::get('search_book','BookController@search');
Route::post('search','BookController@show');
Route::post('post/create','BookController@create');

