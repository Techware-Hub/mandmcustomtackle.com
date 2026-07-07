<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminProductVariantController extends Controller
{
    public function index(Request $request): View
    {
        $variants = ProductVariant::query()
            ->with('product')
            ->when($request->product_id, fn ($query, $productId) => $query->where('product_id', $productId))
            ->when($request->color, fn ($query, $color) => $query->where('color_name', 'like', "%{$color}%"))
            ->when($request->weight, fn ($query, $weight) => $query->where('weight', $weight))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.product-variants.index', [
            'variants' => $variants,
            'products' => Product::orderBy('name')->get(['id', 'name']),
            'defaultWeights' => ProductVariant::DEFAULT_WEIGHTS,
        ]);
    }

    public function edit(ProductVariant $productVariant): View
    {
        return view('admin.product-variants.edit', [
            'variant' => $productVariant->load('product'),
            'products' => Product::orderBy('name')->get(['id', 'name']),
            'defaultColors' => ProductVariant::DEFAULT_COLORS,
            'defaultWeights' => ProductVariant::DEFAULT_WEIGHTS,
        ]);
    }

    public function update(Request $request, ProductVariant $productVariant): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'color_name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $productVariant->update($validated);

        return redirect()->route('admin.product-variants.index')->with('success', 'Product variant updated.');
    }

    public function destroy(ProductVariant $productVariant): RedirectResponse
    {
        $productVariant->delete();

        return back()->with('success', 'Product variant deleted.');
    }
}
