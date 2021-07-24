<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\Users;
use App\Models\Posts;
use App\Http\Requests\CommentFormRequest;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentFormRequest $request)
    {
        //
        $validated = $request->validated();
        $input['from_user'] = $request->user()->id;
        $input['on_post'] = $request->input('on_post');
        $input['body'] = $request->input('body');
        $slug = $request->input('slug');
        Comments::create($input);

        return redirect($slug)->with('message', 'Comment published');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $comment = Comments::find($id);
        $post_id = $comment->on_post;
        $post = Posts::find($post_id);
        return view('comment.edit',compact('comment','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentFormRequest $request, $id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
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
}
