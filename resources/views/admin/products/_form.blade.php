@csrf
@if($product->exists) @method('PUT') @endif
<div class="admin-card grid gap-5 rounded-lg border border-slate-800 bg-slate-900 p-6 lg:grid-cols-2">
    <label><span class="text-sm font-bold">Product Name</span><input name="name" value="{{ old('name', $product->name) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required></label>
    <label><span class="text-sm font-bold">Slug</span><input name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Auto-generated from name" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Category</span><select name="category_id" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
    <label><span class="text-sm font-bold">SKU</span><input name="sku" value="{{ old('sku', $product->sku) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Price</span><input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required></label>
    <label><span class="text-sm font-bold">Sale Price</span><input name="sale_price" type="number" step="0.01" value="{{ old('sale_price', $product->sale_price) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></label>
    <label><span class="text-sm font-bold">Stock</span><input name="stock" type="number" value="{{ old('stock', $product->stock ?? 0) }}" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required></label>
    <label><span class="text-sm font-bold">Status</span><select name="status" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="active" @selected(old('status', $product->status) === 'active')>Active</option><option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option></select></label>
    <label class="lg:col-span-2"><span class="text-sm font-bold">Short Description</span><textarea name="short_description" rows="3" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required>{{ old('short_description', $product->short_description) }}</textarea></label>
    <label class="lg:col-span-2"><span class="text-sm font-bold">Full Description</span><textarea name="description" rows="7" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2" required>{{ old('description', $product->description) }}</textarea></label>
    <label>
        <span class="text-sm font-bold">Main Product Image</span>
        <input name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="mt-2 w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">
        @if($product->image)
            <div class="mt-2 flex items-center gap-3 text-xs text-slate-400"><x-product-image :product="$product" variant="thumb" /> Current image</div>
        @endif
    </label>
    <label class="flex items-center gap-2 pt-7"><input type="checkbox" name="featured" value="1" @checked(old('featured', $product->featured))> Featured Product</label>
    <section class="lg:col-span-2 rounded-lg border border-slate-800 bg-slate-950/70 p-5">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-black text-white">Product Variants</h2>
                <p class="mt-1 text-sm text-slate-400">Add colors, weights, prices, stock, SKU, and status for this product.</p>
            </div>
            <label class="inline-flex items-center gap-2 rounded-lg border border-sky-500/40 bg-sky-500/10 px-3 py-2 text-sm font-bold text-sky-100">
                <input type="checkbox" name="generate_default_variants" value="1">
                Generate Variants From Default Colors & Weights
            </label>
        </div>

        @php
            $variantRows = collect(old('variants', $product->variants ?? []));
        @endphp
        <div class="mt-5 overflow-x-auto">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead class="text-slate-400">
                    <tr>
                        <th class="pb-2">Color</th>
                        <th class="pb-2">Weight</th>
                        <th class="pb-2">Price</th>
                        <th class="pb-2">Stock</th>
                        <th class="pb-2">SKU</th>
                        <th class="pb-2">Status</th>
                        <th class="pb-2">Action</th>
                    </tr>
                </thead>
                <tbody id="variant-rows">
                    @foreach($variantRows as $index => $variant)
                        @php $row = is_array($variant) ? $variant : $variant->toArray(); @endphp
                        <tr class="border-t border-slate-800">
                            <td class="py-2">
                                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}">
                                <input name="variants[{{ $index }}][color_name]" value="{{ $row['color_name'] ?? '' }}" list="variant-colors" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2">
                            </td>
                            <td class="py-2"><input name="variants[{{ $index }}][weight]" value="{{ $row['weight'] ?? '' }}" list="variant-weights" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
                            <td class="py-2"><input name="variants[{{ $index }}][price]" type="number" step="0.01" value="{{ $row['price'] ?? '' }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
                            <td class="py-2"><input name="variants[{{ $index }}][stock]" type="number" value="{{ $row['stock'] ?? 0 }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
                            <td class="py-2"><input name="variants[{{ $index }}][sku]" value="{{ $row['sku'] ?? '' }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
                            <td class="py-2"><select name="variants[{{ $index }}][status]" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="active" @selected(($row['status'] ?? 'active') === 'active')>Active</option><option value="inactive" @selected(($row['status'] ?? 'active') === 'inactive')>Inactive</option></select></td>
                            <td class="py-2"><label class="inline-flex items-center gap-2 text-xs font-bold text-red-200"><input type="checkbox" name="variants[{{ $index }}][delete]" value="1"> Delete</label></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" id="add-variant-row" class="mt-4 rounded-lg border border-sky-500/50 px-4 py-2 font-bold text-sky-100 transition hover:bg-sky-500/10">Add Variant</button>
        <datalist id="variant-colors">@foreach($defaultColors as $color)<option value="{{ $color }}"></option>@endforeach</datalist>
        <datalist id="variant-weights">@foreach($defaultWeights as $weight => $price)<option value="{{ $weight }}"></option>@endforeach</datalist>
    </section>
    <div class="lg:col-span-2 flex justify-end gap-3"><a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-700 px-4 py-2 font-bold">Cancel</a><button class="rounded-lg bg-sky-500 px-5 py-2 font-bold text-slate-950">Save Product</button></div>
</div>
<script>
document.getElementById('add-variant-row')?.addEventListener('click', () => {
    const tbody = document.getElementById('variant-rows');
    const index = tbody.children.length;
    tbody.insertAdjacentHTML('beforeend', `
        <tr class="border-t border-slate-800">
            <td class="py-2"><input type="hidden" name="variants[${index}][id]"><input name="variants[${index}][color_name]" list="variant-colors" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
            <td class="py-2"><input name="variants[${index}][weight]" list="variant-weights" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
            <td class="py-2"><input name="variants[${index}][price]" type="number" step="0.01" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
            <td class="py-2"><input name="variants[${index}][stock]" type="number" value="0" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
            <td class="py-2"><input name="variants[${index}][sku]" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"></td>
            <td class="py-2"><select name="variants[${index}][status]" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2"><option value="active">Active</option><option value="inactive">Inactive</option></select></td>
            <td class="py-2"><button type="button" class="rounded-lg border border-red-500/40 px-3 py-2 text-xs font-bold text-red-200" onclick="this.closest('tr').remove()">Remove</button></td>
        </tr>
    `);
});
</script>
