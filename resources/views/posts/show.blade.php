@extends('layouts.app')
@section('title')
@if($post)
{{ $post->title }}
@if(!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
<button class="btn-edit"><a href="{{url('post/'.$post->slug.'/edit')}}">{{ __('Edit Post') }}</a></button>
@endif
@else
Page does not exist
@endif
@endsection
@section('title-meta')
<p>{{ __($post->created_at->format('M')).' '.__($post->created_at->format('d,Y')).' '.__('At').' '.__($post->created_at->format('h:i')).' '.__($post->created_at->format('a')).' '.__('By') }} <a href="{{ url('/user/'.$post->author_id)}}">{{ $post->author->name }}</a></p>
@endsection
@section('content')
@if($post)
<div>
  {!! $post->body !!}
</div>
<div>
  <h2>{{ __('Leave a comment') }}</h2>
</div>
@if(Auth::guest())
<p>{{ __('Login to Comment') }}</p>
@else
<div class="panel-body">
  <form method="post" action="{{ url('comment') }}">
    @csrf
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="on_post" value="{{ $post->id }}">
    <input type="hidden" name="slug" value="{{ $post->slug }}">
    <div class="form-group">
      <textarea required="required" placeholder="{{ __('Enter comment here') }}" name="body" class="form-control"></textarea>
    </div>
    <input type="submit" name='post_comment' class="btn btn-success" value="{{ __('Post') }}" />
  </form>
</div>
@endif
<div>
  @if($comments)
  <ul style="list-style: none; padding: 0">
    @foreach($comments as $comment)
    <li class="panel-body">
      <div class="list-group">
        <div class="list-group-item">
          <h3>{{ $comment->author->name }}</h3>
          <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
        </div>
        <div class="list-group-item">
          <p>{{ $comment->body }}</p>
        </div>
        @if(!Auth::guest() && ($comment->from_user == Auth::user()->id || Auth::user()->is_admin()))
        <input type="hidden" name="slug" value="{{ $post->slug }}">
        <form action="{{ url('comment/'.$comment->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
        </form>
        <button class="btn"><a href="{{url('comment/'.$comment->id.'/edit')}}">{{ __('Edit Post') }}</a></button>
        @endif
      </div>
    </li>
    @endforeach
  </ul>
  @endif
</div>
@else
404 error
@endif
@endsection
