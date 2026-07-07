@extends('admin.layouts.app')
@section('page-title', 'Order '.$order->order_number)
@section('content')
<div class="grid gap-6 xl:grid-cols-[1fr_380px]">
    <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6">
        <h2 class="text-xl font-black text-white">Order Items</h2>
        <table class="mt-5 w-full text-left text-sm"><thead class="text-slate-400"><tr><th class="py-2">Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>@foreach($order->items as $item)<tr class="border-t border-slate-800"><td class="py-3">{{ $item->product_name }}</td><td>{{ $item->quantity }}</td><td>${{ number_format((float)$item->product_price, 2) }}</td><td>${{ number_format((float)$item->total, 2) }}</td></tr>@endforeach</tbody></table>
        <p class="mt-5 text-right text-2xl font-black text-white">${{ number_format((float)$order->total_amount, 2) }}</p>
    </div>
    <aside class="grid gap-6">
        <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6"><h2 class="font-black text-white">Customer Details</h2><p class="mt-3">{{ $order->customer_name }}</p><p>{{ $order->customer_email }}</p><p>{{ $order->customer_phone }}</p></div>
        <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6"><h2 class="font-black text-white">Shipping</h2><p class="mt-3">{{ $order->shipping_address }}</p><p>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p><p class="mt-3 text-slate-400">{{ $order->order_notes }}</p></div>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6">@csrf @method('PUT')<h2 class="font-black text-white">Status Update</h2><label class="mt-4 block">Order Status<select name="order_status" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">@foreach(['pending','processing','completed','cancelled'] as $status)<option value="{{ $status }}" @selected($order->order_status === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label><label class="mt-4 block">Payment Status<select name="payment_status" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">@foreach(['pending','paid','failed','refunded'] as $status)<option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>@endforeach</select></label><button class="mt-5 w-full rounded-lg bg-sky-500 px-4 py-2 font-bold text-slate-950">Update</button></form>
    </aside>
</div>
@endsection
