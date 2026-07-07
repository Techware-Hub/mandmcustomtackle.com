@extends('admin.layouts.app')
@section('page-title','Add New Blog')
@section('content')<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">@include('admin.blogs._form')</form>@endsection
