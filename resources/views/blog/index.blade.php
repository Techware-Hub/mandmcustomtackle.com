@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-blue-950 md:text-5xl">Fishing Blog</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-700">Helpful notes about tackle selection, Sarasota waters, handmade gear, and Florida fishing.</p>
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach ($posts as $post)
            <article class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
                <div class="mb-5 h-28 rounded-lg bg-gradient-to-br from-sky-100 to-blue-400"></div>
                <h2 class="text-xl font-bold text-blue-950">{{ $post->title }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                <a href="{{ route('blog.show', $post->slug) }}" class="mt-5 inline-block font-bold text-sky-700">Read Article</a>
            </article>
        @endforeach
    </div>
</section>
@endsection
