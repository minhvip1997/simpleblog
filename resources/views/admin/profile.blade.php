@extends('layouts.app')
@section('title')
{{ $user->name }}
@endsection
@section('content')
<div>
  <ul class="list-group">
    <li class="list-group-item">
      Joined on {{$user->created_at->format('M d,Y \a\t h:i a') }}
    </li>
    <li class="list-group-item panel-body">
      <table class="table-padding">
        <style>
          .table-padding td {
            padding: 3px 8px;
          }
        </style>
        <tr>
          <td>{{ __('Total Posts') }}</td>
          <td> {{$posts_count}}</td>
          @if($author && $posts_count)
          <td><a href="{{ url('/my-all-posts')}}">{{ __('Show All') }}</a></td>
          @endif
        </tr>
        <tr>
          <td>{{ __('Published Posts') }}</td>
          <td>{{$posts_active_count}}</td>
          @if($posts_active_count)
          <td><a href="{{ url('/user/'.$user->id.'/posts')}}">{{ __('Show All') }}</a></td>
          @endif
        </tr>
        <tr>
          <td>{{ __('Posts in Draft') }} </td>
          <td>{{$posts_draft_count}}</td>
          @if($author && $posts_draft_count)
          <td><a href="{{ url('my-drafts')}}">{{ __('Show All') }}</a></td>
          @endif
        </tr>
      </table>
    </li>
    <li class="list-group-item">
    {{ __('Total Comments') }} {{$comments_count}} 
    </li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3>{{ __('Latest Posts') }}</h3>
  </div>
  <div class="panel-body">
    @if(!empty($latest_posts[0]))
    @foreach($latest_posts as $latest_post)
    <p>
      <strong><a href="{{ url('/'.$latest_post->slug) }}">{{ $latest_post->title }}</a></strong>
      <span class="well-sm"> {{ __('On').' '.__($latest_post->created_at->format('M')).' '.__($latest_post->created_at->format('d,Y')).' '.__('At').' '.__($latest_post->created_at->format('h:i')).' '.__($latest_post->created_at->format('a'))}}</span>
    </p>
    @endforeach
    @else
    <p>{{ __('You have not written any post till now.') }}</p>
    @endif
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3>{{ __('Latest Comments') }}</h3>
  </div>
  <div class="list-group">
    @if(!empty($latest_comments[0]))
    @foreach($latest_comments as $latest_comment)
    <div class="list-group-item">
      <p>{{ $latest_comment->body }}</p>
      <p> {{ __('On').' '.__($latest_comment->created_at->format('M')).' '.__($latest_comment->created_at->format('d,Y')).' '.__('At').' '.__($latest_comment->created_at->format('h:i')).' '.__($latest_comment->created_at->format('a'))}}</p>
      <p>{{__('On post')}} <a href="{{ url('/'.$latest_comment->post->slug) }}">{{ $latest_comment->post->title }}</a></p>
    </div>
    @endforeach
    @else
    <div class="list-group-item">
      <p>{{ __('You have not commented till now. Your latest 5 comments will be displayed here') }}</p>
    </div>
    @endif
  </div>
</div>
@endsection