<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\Testimonial;
use App\Support\SiteData;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        collect(SiteData::categories())->each(fn (array $category) => Category::updateOrCreate(
            ['slug' => $category['slug']],
            $category
        ));

        collect(SiteData::products())->each(function (array $product, int $index) {
            $category = Category::where('slug', $product['category_slug'])->firstOrFail();
            unset($product['category_slug']);

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [...$product, 'category_id' => $category->id, 'featured' => $index < 4]
            );
        });

        collect(SiteData::testimonials())->each(fn (array $testimonial) => Testimonial::updateOrCreate(
            ['name' => $testimonial['name']],
            $testimonial
        ));

        collect(SiteData::blogPosts())->each(fn (array $post) => BlogPost::updateOrCreate(
            ['slug' => $post['slug']],
            [...$post, 'published_at' => now()]
        ));

        collect(SiteData::galleryItems())->each(fn (array $item) => GalleryItem::updateOrCreate(
            ['title' => $item['title']],
            $item
        ));
    }
}
