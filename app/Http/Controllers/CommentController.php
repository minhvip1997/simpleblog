<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Users;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentFormRequest;

class CommentController extends Controller
{
    //
    public function store(CommentFormRequest $request)
    {
        $validated = $request->validated();
        $input['from_user'] = $request->user()->id;
        $input['on_post'] = $request->input('on_post');
        $input['body'] = $request->input('body');
        $slug = $request->input('slug');
        Comments::create($input);

        return redirect($slug)->with('message', 'Comment published');
    }

    public function delete(Request $request, $id){
        $comment = Comments::find($id);
        $slug = $request->input('slug');
        $post = Posts::where('slug', $slug)->first();
        if($comment && ($comment->from_user == $request->user()->id || $request->user()->is_admin()))
        {
            $comment->delete();
            $data['message'] = 'Comment deleted Successfully';
        }else{
            $data['errors'] = 'Invalid Operation. You have not sufficient permissions';
        }

        return redirect('/')->with($data);
    }

    public function edit($id)
    {
        $comment = Comments::find($id);
        $post_id = $comment->on_post;
        $post = Posts::find($post_id);
        return view('comment.edit',compact('comment','post'));
    }

    public function update(CommentFormRequest $request)
    {
        $validated = $request->validated();
        $post_id = $request->on_post;
        $post = Posts::find($post_id);
        $comment_id = $request->comment_id;
        $slug = $post->slug;
        $comment = Comments::find($comment_id);
        if ($post && ($post->author_id == $request->user()->id || $request->user()->is_admin())) {
        $message = "comment update successfull";
        $comment->body = $request->body;
        $comment->save();
        return redirect('/'.$slug)->withMessage($message);
        } else {
        return redirect('/')->withErrors('you have not sufficient permissions');
        }
    }
}
