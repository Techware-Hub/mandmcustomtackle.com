@extends('admin.layouts.app')
@section('page-title','Add Gallery Item')
@section('content')<form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">@include('admin.gallery._form')</form>@endsection
