<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->when($request->category_id, fn ($query, $category) => $query->where('category_id', $category))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->stock === 'low', fn ($query) => $query->where('stock', '<=', 5))
            ->when($request->stock === 'out', fn ($query) => $query->where('stock', 0))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product(['status' => 'active', 'featured' => false]),
            'categories' => Category::orderBy('name')->get(),
            'defaultColors' => ProductVariant::DEFAULT_COLORS,
            'defaultWeights' => ProductVariant::DEFAULT_WEIGHTS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = Product::create($this->validatedData($request));
        $this->saveVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $product->load('variants');

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'defaultColors' => ProductVariant::DEFAULT_COLORS,
            'defaultWeights' => ProductVariant::DEFAULT_WEIGHTS,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validatedData($request, $product));
        $this->saveVariants($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image && ! str_starts_with($product->image, 'assets/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,'.($product?->id ?? 'NULL')],
            'short_description' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            if ($product?->image && ! str_starts_with($product->image, 'assets/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
            }
            $validated['image'] = 'storage/'.$request->file('image')->store('products', 'public');
        }

        return $validated;
    }

    private function saveVariants(Request $request, Product $product): void
    {
        if ($request->boolean('generate_default_variants')) {
            foreach (ProductVariant::DEFAULT_COLORS as $color) {
                foreach (ProductVariant::DEFAULT_WEIGHTS as $weight => $price) {
                    $product->variants()->updateOrCreate(
                        ['color_name' => $color, 'weight' => $weight],
                        ['price' => $price, 'stock' => 10, 'status' => 'active']
                    );
                }
            }
        }

        $variants = collect($request->input('variants', []))
            ->filter(fn (array $variant) => filled($variant['color_name'] ?? null) && filled($variant['weight'] ?? null));

        foreach ($variants as $variant) {
            if (! empty($variant['delete']) && ! empty($variant['id'])) {
                $product->variants()->whereKey($variant['id'])->delete();
                continue;
            }

            $data = [
                'color_name' => $variant['color_name'],
                'weight' => $variant['weight'],
                'price' => (float) ($variant['price'] ?? 0),
                'sku' => $variant['sku'] ?? null,
                'stock' => (int) ($variant['stock'] ?? 0),
                'status' => in_array(($variant['status'] ?? 'active'), ['active', 'inactive'], true) ? $variant['status'] : 'active',
            ];

            if (! empty($variant['id'])) {
                $product->variants()->whereKey($variant['id'])->update($data);
            } else {
                $product->variants()->updateOrCreate(
                    ['color_name' => $data['color_name'], 'weight' => $data['weight']],
                    $data
                );
            }
        }
    }
}
