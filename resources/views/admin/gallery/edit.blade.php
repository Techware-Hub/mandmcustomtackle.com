@extends('admin.layouts.app')
@section('page-title','Edit Gallery Item')
@section('content')<form method="POST" action="{{ route('admin.gallery.update', $item) }}" enctype="multipart/form-data">@include('admin.gallery._form')</form>@endsection
