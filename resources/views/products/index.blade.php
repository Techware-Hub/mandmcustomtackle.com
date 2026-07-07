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
        @forelse ($products as $product)
            <x-product-card :product="$product" />
        @empty
            <div class="rounded-lg border border-sky-100 bg-white p-8 text-center shadow-sm sm:col-span-2 lg:col-span-4">
                <p class="text-slate-700">No active products are available yet.</p>
            </div>
        @endforelse
    </div>
    @if(method_exists($products, 'links'))
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
</section>
@endsection
