@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <x-section-title eyebrow="Testimonials" title="Realistic feedback from fishing customers" />
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($testimonials as $testimonial)
            <x-testimonial-card :testimonial="$testimonial" />
        @endforeach
    </div>
</section>
@endsection
