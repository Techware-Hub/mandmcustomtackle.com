@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-wide text-sky-700">My Account</p>
            <h1 class="mt-2 text-4xl font-black text-blue-950">Welcome, {{ $user->name }}</h1>
        </div>
        <a href="{{ route('products.index') }}" class="rounded-lg bg-blue-950 px-5 py-3 text-center font-bold text-white transition hover:bg-sky-700">Continue Shopping</a>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_2fr]">
        <aside class="h-fit rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Account Details</h2>
            <dl class="mt-5 grid gap-4 text-sm">
                <div>
                    <dt class="font-bold text-slate-600">Name</dt>
                    <dd class="mt-1 text-slate-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="font-bold text-slate-600">Email</dt>
                    <dd class="mt-1 text-slate-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="font-bold text-slate-600">Role</dt>
                    <dd class="mt-1 capitalize text-slate-900">{{ $user->role }}</dd>
                </div>
            </dl>
        </aside>

        <div class="rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Recent Orders</h2>
            <div class="mt-5 grid gap-4">
                @forelse ($orders as $order)
                    <a href="{{ route('checkout.success', $order) }}" class="rounded-lg border border-sky-100 p-4 transition hover:border-sky-300 hover:bg-sky-50">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-bold text-blue-950">{{ $order->order_number }}</p>
                                <p class="text-sm text-slate-600">{{ $order->created_at->format('M j, Y') }} · {{ $order->items->count() }} item(s)</p>
                            </div>
                            <div class="text-sm font-bold capitalize text-sky-700">{{ $order->order_status }} · ${{ number_format((float) $order->total_amount, 2) }}</div>
                        </div>
                    </a>
                @empty
                    <p class="rounded-lg bg-sky-50 p-4 text-sm text-slate-700">No orders yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
