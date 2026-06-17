@extends('layouts.app')

@section('content')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="reveal rounded-lg border border-sky-100 bg-white p-5 shadow-sm">
        <div class="flex aspect-square items-center justify-center rounded-lg bg-gradient-to-br {{ $product->color ?? 'from-sky-100 to-blue-400' }}">
            <div class="h-28 w-64 rounded-full border-4 border-white/80 bg-white/30"></div>
        </div>
    </div>
    <div class="reveal">
        <span class="rounded-full bg-sky-50 px-3 py-1 text-sm font-bold text-sky-700">{{ $product->category->name }}</span>
        <h1 class="mt-5 text-4xl font-black text-blue-950">{{ $product->name }}</h1>
        <p class="mt-3 text-3xl font-black text-sky-700">${{ number_format((float) $product->price, 2) }}</p>
        <p class="mt-5 leading-8 text-slate-700">{{ $product->description }}</p>
        <p class="mt-3 text-sm font-bold text-slate-600">{{ $product->stock }} in stock</p>
        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 flex max-w-md gap-3">
            @csrf
            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-24 rounded-lg border border-sky-200 px-3 py-3">
            <button class="flex-1 rounded-lg bg-blue-950 px-6 py-3 font-bold text-white transition hover:bg-sky-700">Add to Cart</button>
        </form>
        <div class="mt-8 rounded-lg border border-sky-100 bg-white p-6">
            <h2 class="text-xl font-bold text-blue-950">Product Specifications</h2>
            <ul class="mt-4 grid gap-2 text-sm text-slate-700">
                @foreach ($product->specs ?? [] as $spec)
                    <li class="rounded-lg bg-sky-50 px-3 py-2">{{ $spec }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[1fr_2fr]">
        <div class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Customer Reviews</h2>
            <p class="mt-3 font-bold text-amber-500">5/5 stars</p>
            <p class="mt-3 leading-7 text-slate-700">Clean finish, strong action, and exactly the kind of tackle I want in my saltwater box.</p>
        </div>
        <div>
            <h2 class="mb-6 text-2xl font-bold text-blue-950">Related Products</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
