<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Support\SiteData;
use Illuminate\Database\QueryException;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'metaTitle' => 'About M&M Custom Tackle',
            'metaDescription' => 'Learn about M&M Custom Tackle, a Sarasota custom fishing tackle business owned by Mark Scaperotta.',
        ]);
    }

    public function gallery(): View
    {
        return view('pages.gallery', [
            'metaTitle' => 'Custom Tackle Gallery | M&M Custom Tackle',
            'metaDescription' => 'View custom jigs, jig heads, finished products, and customer fishing photos.',
            'items' => $this->galleryItems(),
        ]);
    }

    public function pricing(): View
    {
        return view('pages.pricing', [
            'metaTitle' => 'Pricing | M&M Custom Tackle',
            'metaDescription' => 'View custom tackle package pricing and bulk order options.',
        ]);
    }

    public function testimonials(): View
    {
        return view('pages.testimonials', [
            'metaTitle' => 'Customer Testimonials | M&M Custom Tackle',
            'metaDescription' => 'Read customer feedback about M&M Custom Tackle products and service.',
            'testimonials' => $this->testimonialsData(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'metaTitle' => 'Contact M&M Custom Tackle',
            'metaDescription' => 'Contact M&M Custom Tackle in Sarasota, Florida for custom fishing tackle orders.',
        ]);
    }

    public function privacy(): View
    {
        return view('pages.privacy-policy', ['metaTitle' => 'Privacy Policy | M&M Custom Tackle']);
    }

    public function terms(): View
    {
        return view('pages.terms', ['metaTitle' => 'Terms & Conditions | M&M Custom Tackle']);
    }

    public function returns(): View
    {
        return view('pages.return-policy', ['metaTitle' => 'Return Policy | M&M Custom Tackle']);
    }

    public function login(): View
    {
        return view('auth.login', ['metaTitle' => 'Customer Login | M&M Custom Tackle']);
    }

    public function register(): View
    {
        return view('auth.register', ['metaTitle' => 'Create Account | M&M Custom Tackle']);
    }

    private function galleryItems()
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

    private function testimonialsData()
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
}
