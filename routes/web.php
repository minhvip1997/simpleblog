<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostsController as PostsController1;
use App\Http\Controllers\CommentsController as CommentsController1;
use App\Http\Controllers\UsersController as UsersController1;

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

Route::get('language/{language}',[App\Http\Controllers\LanguageController::class, 'language'])->name('language.index');
Route::get('/', [PostsController1::class, 'index']);
Route::get('/home', ['as' => 'home', 'uses' => 'App\Http\Controllers\PostsController@index']);

Route::get('/logout', [UsersController1::class,'getLogout']);
Route::group(['prefix' => 'auth'], function () {
  Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    Route::resource('post', PostsController1::class);
    Route::resource('comment', CommentsController1::class);
    // display user's all posts
    Route::get('my-all-posts', [UsersController1::class,'index']);
    // display user's drafts
    Route::get('my-drafts', [UsersController1::class,'store']);
  });

// users profile
Route::get('user/{id}', [UsersController1::class,'profile'])->where('id', '[0-9]+');
// display list of posts
Route::get('user/{id}/posts', [UsersController1::class,'show'])->where('id', '[0-9]+');
// display single post
Route::resource('post', PostsController1::class)->only('show');
