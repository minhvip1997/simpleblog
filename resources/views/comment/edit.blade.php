@extends('layouts.app')
@section('content')
<h1>{{$post->title}}</h1>
<div class="panel-body">
  <form method="post" action="{{ url('comment/'.$comment->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="on_post" value="{{ $post->id }}">
    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
    <input type="hidden" name="slug" value="{{ $post->slug }}">
    <div class="form-group">
      <textarea  placeholder="{{ __('Enter comment here') }}" name="body" class="form-control">{{$comment->body}}</textarea>
    </div>
    <input type="submit" name='post_comment' class="btn btn-success" value="{{ __('Post') }}" />
  </form>
</div>
@endsection