<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Support\SiteData;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = $this->products();
        $categories = $this->categories();
        $activeCategory = $request->query('category');

        if ($activeCategory) {
            $products = $products->filter(fn ($product) => $product->category->slug === $activeCategory);
        }

        return view('products.index', [
            'metaTitle' => 'Shop Custom Fishing Tackle | M&M Custom Tackle',
            'metaDescription' => 'Browse custom jigs, jig heads, bucktail jigs, fishing accessories, and apparel.',
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $slug): View
    {
        $product = $this->products()->firstWhere('slug', $slug) ?? abort(404);
        $related = $this->products()
            ->where('slug', '!=', $slug)
            ->filter(fn ($item) => $item->category->slug === $product->category->slug)
            ->take(3);

        if ($related->isEmpty()) {
            $related = $this->products()->where('slug', '!=', $slug)->take(3);
        }

        return view('products.show', [
            'metaTitle' => $product->name.' | M&M Custom Tackle',
            'metaDescription' => $product->description,
            'product' => $product,
            'related' => $related,
        ]);
    }

    private function categories()
    {
        try {
            $items = Category::query()->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        return collect(SiteData::categories())->map(fn ($item) => (object) $item);
    }

    private function products()
    {
        try {
            $items = Product::query()->with('category')->where('status', 'active')->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        $categories = collect(SiteData::categories())->keyBy('slug');
        return collect(SiteData::products())->map(function ($item) use ($categories) {
            $item['category'] = (object) $categories[$item['category_slug']];
            return (object) $item;
        });
    }
}
