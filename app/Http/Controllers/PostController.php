<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostFormRequest;

class PostController extends Controller
{
    //
    public function index(){
        $posts = Posts::where('active', '1')->orderBy('created_at', 'desc')->paginate(5);
        $title = 'Latest Post';
            return view('home')->withPosts($posts)->withTitle($title);
        }
    
        public function getCreate(Request $request)
        {
            if($request->user()->can_post())
            {
                return view('posts.create');
            }else
            {
                return view('layouts.app');
            }

        }
    
        public function store(PostFormRequest $request)
        {
            $validated = $request->validated();
            $posts = new Posts;
            $posts->title = $request->title;
            $posts->body = $request->body;
            $posts->slug = Str::slug($posts->title);
            
            $posts->author_id = $request->user()->id;
            if ($request->has('save')) {
            $posts->active = 0;
            $message = 'Post saved successfully';
            } else {
            $posts->active = 1;
            $message = 'Post published successfully';
            }
            $posts->save();
            return redirect('newpost')->with('thongbao','Tạo posts thành công');
        }
    
        public function show($slug)
        {
            $post = Posts::where('slug', $slug)->first();
    
            if ($post) {
              if ($post->active == false)
                return redirect('/')->withErrors('requested page not found');
              $comments = $post->comments;
            } else {
              return redirect('/')->withErrors('requested page not found');
            }
            return view('posts.show')->withPost($post)->withComments($comments);
        }
    
        public function edit(Request $request, $slug)
        {
            $post = Posts::where('slug', $slug)->first();
            if ($post && ($request->user()->id == $post->author_id || $request->user()->is_admin()))
            return view('posts.edit')->with('post', $post);
            else {
            return redirect('/')->withErrors('you have not sufficient permissions');
            }
        }
    
        public function update(PostFormRequest $request)
        {
            $validated = $request->validated();
            $post_id = $request->post_id;
            $post = Posts::find($post_id);
            if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
                $title = $request->title;
            $post->title = $title;
            $slug = Str::slug($title);
    
            $post->body = $request->body;
    
            if ($request->has('save')) {
                $post->active = 0;
                $message = 'Post saved successfully';
                $landing = 'edit/' . $post->slug;
            } else {
                $post->active = 1;
                $message = 'Post updated successfully';
                $landing = $post->slug;
            }
            $post->save();
            return redirect('edit/'.$landing)->withMessage($message);
            } else {
            return redirect('/')->withErrors('you have not sufficient permissions');
            }
        }
    
        public function destroy(Request $request, $id)
        {
             //
            $post = Posts::find($id);
            if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
            $post->delete();
            $data['message'] = 'Post deleted Successfully';
            } else {
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
            }
    
            return redirect('/')->with($data);
        }
}
