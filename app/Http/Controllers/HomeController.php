<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Testimonial;
use App\Support\SiteData;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'metaTitle' => 'M&M Custom Tackle | Sarasota Custom Fishing Tackle',
            'metaDescription' => 'Shop handcrafted fishing tackle, custom jigs, jig heads, and saltwater fishing products from Sarasota, Florida.',
            'categories' => $this->categories()->take(4),
            'products' => $this->products()->take(4),
            'testimonials' => $this->testimonials()->take(3),
            'posts' => $this->posts()->take(3),
            'galleryItems' => $this->gallery()->take(3),
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
            $items = Product::query()->with('category')->where('featured', true)->where('status', 'active')->get();
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

    private function testimonials()
    {
        try {
            $items = Testimonial::query()->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        return collect(SiteData::testimonials())->map(fn ($item) => (object) $item);
    }

    private function posts()
    {
        try {
            $items = BlogPost::query()->latest('published_at')->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        return collect(SiteData::blogPosts())->map(fn ($item) => (object) $item);
    }

    private function gallery()
    {
        try {
            $items = GalleryItem::query()->get();
            if ($items->isNotEmpty()) {
                return $items;
            }
        } catch (QueryException) {
        }

        return collect(SiteData::galleryItems())->map(fn ($item) => (object) $item);
    }
}
