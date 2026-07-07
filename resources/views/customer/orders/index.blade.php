@extends('layouts.app')
@section('content')
<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8"><h1 class="text-4xl font-black text-blue-950">Order History</h1><div class="mt-8 grid gap-4">@forelse($orders as $order)<a href="{{ route('customer.orders.show', $order) }}" class="rounded-lg border border-sky-100 bg-white p-5 shadow-sm"><strong>{{ $order->order_number }}</strong><span class="ml-3 capitalize text-slate-600">{{ $order->order_status }}</span><span class="float-right font-bold text-sky-700">${{ number_format((float)$order->total_amount, 2) }}</span><p class="mt-2 text-sm text-slate-600">{{ $order->created_at->format('M j, Y') }}</p></a>@empty<p>No orders yet.</p>@endforelse</div><div class="mt-5">{{ $orders->links() }}</div></section>
@endsection
