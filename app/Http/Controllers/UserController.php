<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getLogout()
   {
       Auth::logout();
       return redirect('/home');
   }

   public function user_posts_all(Request $request)
   {
     //
     $user = $request->user();
     $posts = Post::where('author_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
     $title = $user->name;
     return view('home')->withPosts($posts)->withTitle($title);
   }
 
   public function user_posts_draft(Request $request)
   {
     //
     $user = $request->user();
     $posts = Post::where('author_id', $user->id)->where('active', '0')->orderBy('created_at', 'desc')->paginate(5);
     $title = $user->name;
     return view('home')->withPosts($posts)->withTitle($title);
   }

}
