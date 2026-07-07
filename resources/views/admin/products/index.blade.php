@extends('admin.layouts.app')
@section('page-title', 'All Products')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <form class="grid flex-1 gap-3 sm:grid-cols-4">
        <input name="search" value="{{ request('search') }}" placeholder="Search products" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm">
        <select name="category_id" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm"><option value="">All categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select>
        <select name="status" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm"><option value="">All statuses</option><option value="active" @selected(request('status') === 'active')>Active</option><option value="inactive" @selected(request('status') === 'inactive')>Inactive</option></select>
        <select name="stock" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-sm"><option value="">All stock</option><option value="low" @selected(request('stock') === 'low')>Low stock</option><option value="out" @selected(request('stock') === 'out')>Out of stock</option></select>
        <button class="rounded-lg bg-sky-500 px-4 py-2 font-bold text-slate-950 sm:col-span-4">Filter</button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-sky-500 px-4 py-3 text-center font-bold text-slate-950">Add Product</a>
</div>
<div class="admin-card overflow-hidden rounded-lg border border-slate-800 bg-slate-900">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-950 text-slate-400"><tr><th class="p-3">Image</th><th class="p-3">Name</th><th class="p-3">Category</th><th class="p-3">Price</th><th class="p-3">Stock</th><th class="p-3">Featured</th><th class="p-3">Status</th><th class="p-3">Created</th><th class="p-3">Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
            <tr class="border-t border-slate-800">
                <td class="p-3"><x-product-image :product="$product" variant="thumb" /></td>
                <td class="p-3 font-bold text-white">{{ $product->name }}</td><td class="p-3">{{ $product->category->name }}</td><td class="p-3">${{ number_format((float)$product->price, 2) }}</td><td class="p-3">{{ $product->stock }}</td><td class="p-3">{{ $product->featured ? 'Yes' : 'No' }}</td><td class="p-3 capitalize">{{ $product->status }}</td><td class="p-3">{{ $product->created_at->format('M j, Y') }}</td>
                <td class="p-3"><div class="flex gap-2"><a href="{{ route('admin.products.edit', $product) }}" class="text-sky-300 font-bold">Edit</a><form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">@csrf @method('DELETE')<button class="text-red-300 font-bold">Delete</button></form></div></td>
            </tr>
        @empty
            <tr><td colspan="9" class="p-5 text-slate-400">No products found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $products->links() }}</div>
@endsection
