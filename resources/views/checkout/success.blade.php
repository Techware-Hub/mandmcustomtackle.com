@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="rounded-lg bg-gradient-to-br from-sky-100 via-white to-cyan-100 p-8 text-center shadow-sm">
        <p class="text-sm font-bold uppercase tracking-wide text-sky-700">Order Confirmed</p>
        <h1 class="mt-3 text-4xl font-black text-blue-950 md:text-5xl">Thank you for your order</h1>
        <p class="mx-auto mt-4 max-w-2xl leading-7 text-slate-700">M&M Custom Tackle received your order and will follow up if any custom details are needed.</p>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Order Summary</h2>
            <div class="mt-5 grid gap-4">
                @foreach ($order->items as $item)
                    <div class="flex justify-between gap-4 rounded-lg bg-sky-50 px-4 py-3">
                        <div class="flex gap-3">
                            <x-product-image :product="$item->product" :name="$item->product_name" variant="summary" />
                            <div>
                                <p class="font-bold text-blue-950">{{ $item->product_name }}</p>
                                @if($item->variant_color || $item->variant_weight)
                                    <p class="text-sm text-slate-600">{{ $item->variant_color }} / {{ $item->variant_weight }}</p>
                                @endif
                                <p class="text-sm text-slate-600">${{ number_format($item->product_price, 2) }} x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <strong class="text-blue-950">${{ number_format($item->total, 2) }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <aside class="h-fit rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Details</h2>
            <div class="mt-5 space-y-3 text-sm text-slate-700">
                <div class="flex justify-between gap-4"><span>Order Number</span><strong>{{ $order->order_number }}</strong></div>
                <div class="flex justify-between gap-4"><span>Customer</span><strong>{{ $order->customer_name }}</strong></div>
                <div class="flex justify-between gap-4"><span>Total</span><strong>${{ number_format($order->total_amount, 2) }}</strong></div>
                <div class="flex justify-between gap-4"><span>Payment</span><strong class="capitalize">{{ $order->payment_status }}</strong></div>
                <div class="flex justify-between gap-4"><span>Status</span><strong class="capitalize">{{ $order->order_status }}</strong></div>
            </div>
            <a href="{{ route('products.index') }}" class="mt-6 block rounded-lg bg-blue-950 px-5 py-3 text-center font-bold text-white transition hover:bg-sky-700">Continue Shopping</a>
            <div class="mt-6 rounded-lg bg-sky-50 p-4 text-sm text-slate-700">
                <p class="font-bold text-blue-950">Questions?</p>
                <p class="mt-2"><a href="mailto:Mandmcustomtackle@gmail.com" class="text-sky-700">Mandmcustomtackle@gmail.com</a></p>
                <p><a href="tel:+19415441066" class="text-sky-700">(941) 544-1066</a></p>
            </div>
        </aside>
    </div>
</section>
@endsection
