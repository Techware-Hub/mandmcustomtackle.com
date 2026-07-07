<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\GalleryItem;
use App\Models\Product;
use App\Models\ProductVariant;
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

            $savedProduct = Product::updateOrCreate(
                ['slug' => $product['slug']],
                [...$product, 'category_id' => $category->id, 'featured' => $index < 4]
            );

            if (in_array($savedProduct->name, ['M&M Custom Jig', 'Sarasota Snook Jig', 'Flare Hawk Jig', 'Bucktail Jig', 'Pompano Jig', 'Custom Flare Hawk Jig', 'Bluewater Bucktail Jig', 'Pompano Surf Jig'], true)) {
                foreach (ProductVariant::DEFAULT_COLORS as $color) {
                    foreach (ProductVariant::DEFAULT_WEIGHTS as $weight => $price) {
                        $savedProduct->variants()->updateOrCreate(
                            ['color_name' => $color, 'weight' => $weight],
                            [
                                'price' => $price,
                                'sku' => $savedProduct->sku.'-'.strtoupper(str_replace([' ', '/', '&'], '-', $color.'-'.$weight)),
                                'stock' => 10,
                                'status' => 'active',
                            ]
                        );
                    }
                }
            }
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
