@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-blue-950">Shopping Cart</h1>
    <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_360px]">
        <div class="space-y-4">
            @forelse ($cartItems as $item)
                <div class="rounded-lg border border-sky-100 bg-white p-4 shadow-sm md:flex md:items-center md:gap-5">
                    <div class="h-24 w-24 rounded-lg bg-gradient-to-br {{ $item->product->color }}"></div>
                    <div class="mt-4 flex-1 md:mt-0">
                        <h2 class="text-xl font-bold text-blue-950">{{ $item->product->name }}</h2>
                        <p class="text-sm text-slate-600">${{ number_format($item->product->price, 2) }} each</p>
                    </div>
                    <form method="POST" action="{{ route('cart.update') }}" class="mt-4 flex items-center gap-2 md:mt-0">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-20 rounded-lg border border-sky-200 px-3 py-2">
                        <button class="rounded-lg border border-sky-200 px-3 py-2 text-sm font-bold">Update</button>
                    </form>
                    <p class="mt-4 w-24 font-bold text-blue-950 md:mt-0">${{ number_format($item->lineTotal, 2) }}</p>
                    <form method="POST" action="{{ route('cart.remove', $item->product) }}">
                        @csrf
                        <button class="mt-3 text-sm font-bold text-red-600 md:mt-0">Remove</button>
                    </form>
                </div>
            @empty
                <div class="rounded-lg border border-sky-100 bg-white p-8 text-center shadow-sm">
                    <p class="text-slate-700">Your cart is empty.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block rounded-lg bg-blue-950 px-5 py-3 font-bold text-white">Shop Products</a>
                </div>
            @endforelse
        </div>
        <aside class="h-fit rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Order Summary</h2>
            <div class="mt-5 space-y-3 text-slate-700">
                <div class="flex justify-between"><span>Subtotal</span><strong>${{ number_format($subtotal, 2) }}</strong></div>
                <div class="flex justify-between"><span>Shipping</span><strong>${{ number_format($shipping, 2) }}</strong></div>
                <div class="border-t border-sky-100 pt-3 flex justify-between text-lg text-blue-950"><span>Total</span><strong>${{ number_format($subtotal + $shipping, 2) }}</strong></div>
            </div>
            <a href="{{ route('checkout.index') }}" class="mt-6 block rounded-lg bg-sky-500 px-5 py-3 text-center font-bold text-white transition hover:bg-blue-700">Proceed to Checkout</a>
            @if ($cartItems->isNotEmpty())
                <form method="POST" action="{{ route('cart.clear') }}" class="mt-3">
                    @csrf
                    <button class="w-full rounded-lg border border-sky-200 px-5 py-3 text-center font-bold text-blue-950 transition hover:bg-sky-50">Clear Cart</button>
                </form>
            @endif
        </aside>
    </div>
</section>
@endsection
