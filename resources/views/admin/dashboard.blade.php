@extends('admin.layouts.app')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach ([
        ['Total Products', $totalProducts],
        ['Categories', $totalCategories],
        ['Total Orders', $totalOrders],
        ['Pending Orders', $pendingOrders],
        ['Completed Orders', $completedOrders],
        ['Revenue', '$'.number_format((float) $totalRevenue, 2)],
        ['Customers', $totalCustomers],
        ['Messages', $totalContactMessages],
        ['Low Stock', $lowStockProducts->count()],
        ['Blog Posts', $totalBlogs],
    ] as [$label, $value])
        <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-5 shadow-xl shadow-sky-950/10">
            <p class="text-sm font-bold text-slate-400">{{ $label }}</p>
            <p class="mt-2 text-3xl font-black text-white">{{ $value }}</p>
        </div>
    @endforeach
</div>

<div class="mt-8 grid gap-8 xl:grid-cols-[1.4fr_.9fr]">
    <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6 shadow-xl shadow-sky-950/10">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-black text-white">Sales Overview</h2>
            <span class="rounded-full bg-sky-500/15 px-3 py-1 text-xs font-bold text-sky-200">Static preview</span>
        </div>
        <div class="mt-6 flex h-64 items-end gap-3 rounded-lg bg-slate-950/70 p-4">
            @foreach ([32, 48, 38, 76, 55, 88, 64, 92] as $height)
                <div class="flex flex-1 items-end">
                    <div class="w-full rounded-t bg-sky-400/80" style="height: {{ $height }}%"></div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6 shadow-xl shadow-sky-950/10">
        <h2 class="text-xl font-black text-white">Quick Actions</h2>
        <div class="mt-5 grid gap-3">
            <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-sky-500 px-4 py-3 text-center font-bold text-slate-950">Add Product</a>
            <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-slate-700 px-4 py-3 text-center font-bold text-sky-200">View Orders</a>
            <a href="{{ route('admin.blogs.create') }}" class="rounded-lg border border-slate-700 px-4 py-3 text-center font-bold text-sky-200">Add Blog</a>
            <a href="{{ route('admin.messages.index') }}" class="rounded-lg border border-slate-700 px-4 py-3 text-center font-bold text-sky-200">View Messages</a>
            <a href="{{ route('admin.settings.index') }}" class="rounded-lg border border-slate-700 px-4 py-3 text-center font-bold text-sky-200">Website Settings</a>
        </div>
    </div>
</div>

<div class="mt-8 grid gap-8 xl:grid-cols-2">
    <section class="admin-card overflow-hidden rounded-lg border border-slate-800 bg-slate-900 shadow-xl shadow-sky-950/10">
        <div class="border-b border-slate-800 p-5"><h2 class="text-xl font-black text-white">Recent Orders</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-950 text-slate-400">
                    <tr><th class="p-3">Order</th><th class="p-3">Customer</th><th class="p-3">Total</th><th class="p-3">Payment</th><th class="p-3">Status</th><th class="p-3">Date</th><th class="p-3">Action</th></tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr class="border-t border-slate-800">
                            <td class="p-3 font-bold text-white">{{ $order->order_number }}</td>
                            <td class="p-3">{{ $order->customer_name }}</td>
                            <td class="p-3">${{ number_format((float) $order->total_amount, 2) }}</td>
                            <td class="p-3 capitalize">{{ $order->payment_status }}</td>
                            <td class="p-3 capitalize">{{ $order->order_status }}</td>
                            <td class="p-3">{{ $order->created_at->format('M j') }}</td>
                            <td class="p-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-sky-300 font-bold">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-5 text-slate-400">No orders yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-card overflow-hidden rounded-lg border border-slate-800 bg-slate-900 shadow-xl shadow-sky-950/10">
        <div class="border-b border-slate-800 p-5"><h2 class="text-xl font-black text-white">Recent Contact Messages</h2></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-950 text-slate-400">
                    <tr><th class="p-3">Name</th><th class="p-3">Email</th><th class="p-3">Subject</th><th class="p-3">Date</th><th class="p-3">Status</th><th class="p-3">Action</th></tr>
                </thead>
                <tbody>
                    @forelse ($recentContactMessages as $message)
                        <tr class="border-t border-slate-800">
                            <td class="p-3 font-bold text-white">{{ $message->name }}</td>
                            <td class="p-3">{{ $message->email }}</td>
                            <td class="p-3">{{ $message->subject }}</td>
                            <td class="p-3">{{ $message->created_at->format('M j') }}</td>
                            <td class="p-3">{{ $message->read_at ? 'Read' : 'Unread' }}</td>
                            <td class="p-3"><a href="{{ route('admin.messages.show', $message) }}" class="text-sky-300 font-bold">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-5 text-slate-400">No messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<section class="admin-card mt-8 overflow-hidden rounded-lg border border-slate-800 bg-slate-900 shadow-xl shadow-sky-950/10">
    <div class="border-b border-slate-800 p-5"><h2 class="text-xl font-black text-white">Low Stock Products</h2></div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950 text-slate-400">
                <tr><th class="p-3">Product</th><th class="p-3">SKU</th><th class="p-3">Current Stock</th><th class="p-3">Status</th><th class="p-3">Action</th></tr>
            </thead>
            <tbody>
                @forelse ($lowStockProducts as $product)
                    <tr class="border-t border-slate-800">
                        <td class="p-3 font-bold text-white">{{ $product->name }}</td>
                        <td class="p-3">{{ $product->sku ?? 'N/A' }}</td>
                        <td class="p-3">{{ $product->stock }}</td>
                        <td class="p-3 capitalize">{{ $product->status }}</td>
                        <td class="p-3"><a href="{{ route('admin.products.edit', $product) }}" class="text-sky-300 font-bold">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-5 text-slate-400">No low stock products.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
