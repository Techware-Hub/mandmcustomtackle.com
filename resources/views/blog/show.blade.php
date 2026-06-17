@extends('layouts.app')

@section('content')
<article class="mx-auto max-w-3xl px-4 py-14 sm:px-6 lg:px-8">
    <a href="{{ route('blog.index') }}" class="text-sm font-bold text-sky-700">Back to Blog</a>
    <h1 class="mt-5 text-4xl font-black text-blue-950 md:text-5xl">{{ $post->title }}</h1>
    <p class="mt-5 text-lg leading-8 text-slate-700">{{ $post->excerpt }}</p>
    <div class="my-8 aspect-[16/9] rounded-lg bg-gradient-to-br from-sky-100 to-blue-500"></div>
    <div class="prose prose-slate max-w-none">
        <p class="leading-8 text-slate-700">{{ $post->body }}</p>
        <p class="leading-8 text-slate-700">For custom tackle recommendations, contact M&M Custom Tackle with your target species, fishing location, preferred weight, and color ideas.</p>
    </div>
</article>
@endsection
