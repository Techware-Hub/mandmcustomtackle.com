@extends('admin.layouts.app')
@section('page-title','Edit Testimonial')
@section('content')<form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">@include('admin.testimonials._form')</form>@endsection
