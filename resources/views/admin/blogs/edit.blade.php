@extends('admin.layouts.app')
@section('page-title','Edit Blog')
@section('content')<form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">@include('admin.blogs._form')</form>@endsection
