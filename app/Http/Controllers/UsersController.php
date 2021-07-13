<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user = $request->user();
        $posts = Posts::where('author_id', $user->id)->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();
        $posts = Posts::where('author_id', $user->id)->where('active', '0')->orderBy('created_at', 'desc')->paginate(5);
        $title = $user->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $posts = Posts::where('author_id', $id)->where('active', '1')->orderBy('created_at', 'desc')->paginate(5);
        $title = User::find($id)->name;
        return view('home')->withPosts($posts)->withTitle($title);
    }

    public function profile(Request $request, $id)
    {
          $data['user'] = User::find($id);
          if (!$data['user'])
          return redirect('/');
  
          if ($request->user() && $data['user']->id == $request->user()->id) {
          $data['author'] = true;
          } else {
          $data['author'] = null;
          }
          $data['comments_count'] = $data['user']->comments->count();
          $data['posts_count'] = $data['user']->posts->count();
          $data['posts_active_count'] = $data['user']->posts->where('active', 1)->count();
          $data['posts_draft_count'] = $data['posts_count'] - $data['posts_active_count'];
          $data['latest_posts'] = $data['user']->posts->where('active', 1)->take(5);
          $data['latest_comments'] = $data['user']->comments->take(5);
          return view('admin.profile', $data);
    }

        //
        public function getLogout()
        {
            Auth::logout();
            return redirect('/home');
        }
}
