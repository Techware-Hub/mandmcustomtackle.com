@extends('admin.layouts.app')
@section('page-title', 'Edit Variant')
@section('content')
<form method="POST" action="{{ route('admin.product-variants.update', $variant) }}" class="admin-card grid max-w-4xl gap-5 rounded-lg border border-slate-800 bg-slate-900 p-6 md:grid-cols-2">
    @csrf
    @method('PUT')
    <label><span class="text-sm font-bold">Product</span><select name="product_id" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">@foreach($products as $product)<option value="{{ $product->id }}" @selected(old('product_id', $variant->product_id) == $product->id)>{{ $product->name }}</option>@endforeach</select></label>
    <label><span class="text-sm font-bold">Color</span><input name="color_name" value="{{ old('color_name', $variant->color_name) }}" list="variant-colors" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Weight</span><input name="weight" value="{{ old('weight', $variant->weight) }}" list="variant-weights" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Price</span><input name="price" type="number" step="0.01" value="{{ old('price', $variant->price) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Stock</span><input name="stock" type="number" value="{{ old('stock', $variant->stock) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">SKU</span><input name="sku" value="{{ old('sku', $variant->sku) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Status</span><select name="status" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="active" @selected(old('status', $variant->status) === 'active')>Active</option><option value="inactive" @selected(old('status', $variant->status) === 'inactive')>Inactive</option></select></label>
    <div class="flex justify-end gap-3 md:col-span-2"><a href="{{ route('admin.product-variants.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 font-bold">Cancel</a><button class="rounded-lg bg-sky-500 px-5 py-2 font-bold text-slate-950">Save Variant</button></div>
    <datalist id="variant-colors">@foreach($defaultColors as $color)<option value="{{ $color }}"></option>@endforeach</datalist>
    <datalist id="variant-weights">@foreach($defaultWeights as $weight => $price)<option value="{{ $weight }}"></option>@endforeach</datalist>
</form>
@endsection
