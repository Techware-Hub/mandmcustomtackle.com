@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-white to-sky-100 py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-blue-950 md:text-5xl">Shop Fishing Products</h1>
        <p class="mt-4 max-w-2xl leading-7 text-slate-700">Browse custom tackle, jig heads, bucktails, saltwater accessories, and apparel.</p>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="rounded-full px-4 py-2 text-sm font-bold {{ $activeCategory ? 'bg-white text-blue-950' : 'bg-blue-950 text-white' }}">All</a>
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="rounded-full px-4 py-2 text-sm font-bold {{ $activeCategory === $category->slug ? 'bg-blue-950 text-white' : 'bg-white text-blue-950' }}">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>
</section>
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</section>
@endsection
