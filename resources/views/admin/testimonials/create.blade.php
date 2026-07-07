@extends('admin.layouts.app')
@section('page-title','Add Testimonial')
@section('content')<form method="POST" action="{{ route('admin.testimonials.store') }}">@include('admin.testimonials._form')</form>@endsection
