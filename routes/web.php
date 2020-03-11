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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('follow/{user}','FollowsController@store');

//Profile用ルート
Route::get('profile/{user}','ProfilesController@index');
Route::get('profile/{user}/edit','ProfilesController@edit');
Route::patch('profile/{user}','ProfilesController@update');

//Post用ルート
Route::resource('post','PostController');
