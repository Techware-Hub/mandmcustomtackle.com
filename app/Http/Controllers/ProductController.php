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
        $products = $this->products($request);
        $categories = $this->categories();
        $activeCategory = $request->query('category');

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
        try {
            $product = Product::query()
                ->with(['category', 'variants'])
                ->where('status', 'active')
                ->where('slug', $slug)
                ->firstOrFail();

            $related = Product::query()
                ->with(['category', 'variants'])
                ->where('status', 'active')
                ->where('slug', '!=', $slug)
                ->where('category_id', $product->category_id)
                ->take(3)
                ->get();

            if ($related->isEmpty()) {
                $related = Product::query()
                    ->with(['category', 'variants'])
                    ->where('status', 'active')
                    ->where('slug', '!=', $slug)
                    ->take(3)
                    ->get();
            }
        } catch (QueryException) {
            $product = $this->fallbackProducts()->firstWhere('slug', $slug) ?? abort(404);
            $related = $this->fallbackProducts()
                ->where('slug', '!=', $slug)
                ->filter(fn ($item) => $item->category->slug === $product->category->slug)
                ->take(3);
        }

        if ($related->isEmpty()) {
            $related = $this->fallbackProducts()->where('slug', '!=', $slug)->take(3);
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

    private function products(Request $request)
    {
        try {
            $query = Product::query()
                ->with(['category', 'variants'])
                ->where('status', 'active')
                ->where('stock', '>', 0)
                ->when($request->query('category'), fn ($query, $slug) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $slug)))
                ->latest();

            return $query->paginate(12)->withQueryString();
        } catch (QueryException) {
        }

        return $this->fallbackProducts();
    }

    private function fallbackProducts()
    {
        $categories = collect(SiteData::categories())->keyBy('slug');
        return collect(SiteData::products())->map(function ($item) use ($categories) {
            $item['category'] = (object) $categories[$item['category_slug']];
            $item['variants'] = collect();
            return (object) $item;
        });
    }
}
