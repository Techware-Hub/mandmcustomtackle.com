@extends('admin.layouts.app')
@section('page-title', 'Product Variants')
@section('content')
<form method="GET" class="admin-card grid gap-4 rounded-lg border border-slate-800 bg-slate-900 p-5 md:grid-cols-5">
    <select name="product_id" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="">All Products</option>@foreach($products as $product)<option value="{{ $product->id }}" @selected(request('product_id') == $product->id)>{{ $product->name }}</option>@endforeach</select>
    <input name="color" value="{{ request('color') }}" placeholder="Color" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">
    <select name="weight" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="">All Weights</option>@foreach($defaultWeights as $weight => $price)<option value="{{ $weight }}" @selected(request('weight') === $weight)>{{ $weight }}</option>@endforeach</select>
    <select name="status" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="">All Statuses</option><option value="active" @selected(request('status') === 'active')>Active</option><option value="inactive" @selected(request('status') === 'inactive')>Inactive</option></select>
    <button class="rounded-lg bg-sky-500 px-4 py-2 font-bold text-slate-950">Filter</button>
</form>
<div class="admin-card mt-6 overflow-x-auto rounded-lg border border-slate-800 bg-slate-900 p-5">
    <table class="w-full min-w-[900px] text-left text-sm">
        <thead class="text-slate-400"><tr><th class="py-2">Product</th><th>Color</th><th>Weight</th><th>Price</th><th>Stock</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
        <tbody>
            @forelse($variants as $variant)
                <tr class="border-t border-slate-800">
                    <td class="py-3">{{ $variant->product->name }}</td>
                    <td>{{ $variant->color_name }}</td>
                    <td>{{ $variant->weight }}</td>
                    <td>${{ number_format((float) $variant->price, 2) }}</td>
                    <td>{{ $variant->stock }}</td>
                    <td><span class="rounded-full px-2 py-1 text-xs font-bold {{ $variant->status === 'active' ? 'bg-emerald-500/15 text-emerald-200' : 'bg-slate-700 text-slate-300' }}">{{ ucfirst($variant->status) }}</span></td>
                    <td class="flex justify-end gap-2 py-3">
                        <a href="{{ route('admin.product-variants.edit', $variant) }}" class="rounded-lg border border-slate-700 px-3 py-2 font-bold text-sky-100">Edit</a>
                        <form method="POST" action="{{ route('admin.product-variants.destroy', $variant) }}">@csrf @method('DELETE')<button class="rounded-lg border border-red-500/40 px-3 py-2 font-bold text-red-200">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="py-8 text-center text-slate-400">No variants found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-5">{{ $variants->links() }}</div>
</div>
@endsection
