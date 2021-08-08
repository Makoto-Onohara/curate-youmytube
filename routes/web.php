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

// if(config('app.env') === 'production'){
    // asset()やurl()がhttpsで生成される
    URL::forceScheme('https');
// };

Route::get('/', 'UsersController@index');


// 認証
// 新規登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
// ログアウト
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


// マイページ
Route::resource('users', 'UsersController', ['only' => ['show']]);

Route::group(['prefix' => 'users/{id}'], function(){
   Route::get('followings', 'UsersController@followings')->name('followings');
   Route::get('followers', 'UsersController@followers')->name('followers');
   
});

// 動画登録・チャンネル名・ユーザ名の変更
Route::group(['middleware' => 'auth'], function(){
    Route::put('users', 'UsersController@rename')->name('rename');
    
    // 前にusers/{id}をつけてエンドポイントを指定
    Route::group(['prefix' => 'users/{id}'], function(){
       Route::post('follow', 'UserFollowController@store')->name('follow');
       Route::delete('unfollow', 'UserFollowController@destroy')->name('unfollow');
       
    });
    
    Route::resource('movies', 'MoviesController',['only' => ['create', 'store', 'destroy']]);
});



