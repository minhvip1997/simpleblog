<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PostsController as PostsController1;
use App\Http\Controllers\CommentsController as CommentsController1;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('language/{language}',[App\Http\Controllers\LanguageController::class, 'language'])->name('language.index');

Route::get('/', [App\Http\Controllers\PostController::class, 'index']);
Route::get('/home', ['as' => 'home', 'uses' => 'App\Http\Controllers\PostController@index']);

Route::get('/logout', [App\Http\Controllers\UserController::class,'getLogout']);
Route::group(['prefix' => 'auth'], function () {
  Auth::routes();
});

Route::middleware(['auth'])->group(function () {
    // show new post form
    //Route::get('newpost', [App\Http\Controllers\PostController::class,'getCreate']);
    // save new post
    //Route::post('newpost', [App\Http\Controllers\PostController::class,'store']);
    // edit post form
    //Route::get('edit/{slug}', [App\Http\Controllers\PostController::class,'edit']);
    // update post
    //Route::post('update', [App\Http\Controllers\PostController::class,'update']);
    // delete post
    //Route::get('delete/{id}', [App\Http\Controllers\PostController::class,'destroy']);
    // resource post
    Route::resource('post', PostsController1::class);
    Route::resource('comment', CommentsController1::class);
  });

//users profile
Route::get('user/{id}', [App\Http\Controllers\UserController::class,'profile'])->where('id', '[0-9]+');
// display list of posts
Route::get('user/{id}/posts', [App\Http\Controllers\UserController::class,'user_posts'])->where('id', '[0-9]+');
// display single post
Route::get('/{slug}', ['as' => 'post', 'uses' => 'App\Http\Controllers\PostController@show'])->where('slug', '[A-Za-z0-9-_]+');
