@extends('layouts.app')
@section('title')
{{ __('Add New Post') }}
@endsection
@section('content')
<script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
  tinymce.init({
    selector: "textarea",
    plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
  });
</script>
@if(count($errors)>0)
<div class="alert alert-danger">
   @foreach($errors->all() as $err)
   {{$err}}<br>
   @endforeach
</div>
@endif
@if(session('thongbao'))
<div class="alert alert-success">
   {{session('thongbao')}}
</div>
@endif
<form action="{{url('post')}}" method="POST">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="form-group">
    <input required="required" value="{{ old('title') }}" placeholder="{{ __('Enter title here') }}" type="text" name="title" class="form-control" />
  </div>
  <div class="form-group">
    <textarea name='body' class="form-control">{{ old('body') }}</textarea>
  </div>
  <input type="submit" name='publish' class="btn btn-success" value="{{ __('Publish') }}" />
  <input type="submit" name='save' class="btn btn-default" value="{{ __('Save Draft') }}" />
</form>
@endsection