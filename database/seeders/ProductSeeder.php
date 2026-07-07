<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'M&M Custom Jig', 'slug' => 'mm-custom-jig', 'category' => 'custom-jigs', 'price' => 2.50, 'stock' => 100, 'sku' => 'MM-CUSTOM-JIG', 'featured' => true, 'image' => 'assets/images/products/mm-custom-jig.jpg', 'color' => 'from-sky-100 via-white to-blue-500', 'short' => 'Custom color and weight jig options for local saltwater anglers.', 'description' => 'A flexible custom jig platform with selectable colors, weights, and prices for Sarasota-area fishing.'],
            ['name' => 'Sarasota Snook Jig', 'slug' => 'sarasota-snook-jig', 'category' => 'snook-jigs', 'price' => 2.50, 'stock' => 100, 'sku' => 'MM-SNOOK-JIG', 'featured' => true, 'image' => 'assets/images/products/sarasota-snook-jig.jpg', 'color' => 'from-sky-200 via-white to-blue-400', 'short' => 'Balanced snook jig with color and weight options.', 'description' => 'Designed for Sarasota passes, bridges, and dock lights where snook respond to compact profiles and dependable action.'],
            ['name' => 'Flare Hawk Jig', 'slug' => 'flare-hawk-jig', 'category' => 'custom-jigs', 'price' => 2.50, 'stock' => 100, 'sku' => 'MM-FLARE-HAWK', 'featured' => true, 'image' => 'assets/images/products/flare-hawk-jig.jpg', 'color' => 'from-white via-sky-200 to-blue-700', 'short' => 'Flare hawk style jig with selectable custom finishes.', 'description' => 'A serious bridge and inlet presentation with customer-selectable color and weight combinations.'],
            ['name' => 'Bucktail Jig', 'slug' => 'bucktail-jig', 'category' => 'bucktail-jigs', 'price' => 2.50, 'stock' => 100, 'sku' => 'MM-BUCKTAIL-JIG', 'featured' => true, 'image' => 'assets/images/products/bucktail-jig.jpg', 'color' => 'from-blue-200 via-cyan-100 to-sky-600', 'short' => 'Classic bucktail action with custom color and weight choices.', 'description' => 'Premium bucktail styling for clear water, current, and aggressive saltwater strikes.'],
            ['name' => 'Pompano Jig', 'slug' => 'pompano-jig', 'category' => 'pompano-jigs', 'price' => 2.50, 'stock' => 100, 'sku' => 'MM-POMPANO-JIG', 'featured' => true, 'image' => 'assets/images/products/pompano-jig.jpg', 'color' => 'from-cyan-100 via-white to-amber-100', 'short' => 'Compact surf jig with bright custom options.', 'description' => 'Built for beach, surf, and sandbar presentations where pompano want compact flash and fast action.'],
            ['name' => 'Saltwater Jig Head', 'slug' => 'saltwater-jig-head', 'category' => 'jig-heads', 'price' => 6.75, 'stock' => 100, 'sku' => 'MM-SALT-JIG-HEAD', 'featured' => true, 'image' => 'assets/images/products/saltwater-jig-head.jpg', 'color' => 'from-slate-100 via-sky-100 to-cyan-500', 'short' => 'Durable jig heads for saltwater structure and soft plastics.', 'description' => 'A clean, durable jig head option for pairing with soft plastics in demanding saltwater situations.'],
            ['name' => 'Custom Tackle Pack', 'slug' => 'custom-tackle-pack', 'category' => 'specialty-tackle', 'price' => 34.00, 'stock' => 100, 'sku' => 'MM-TACKLE-PACK', 'featured' => false, 'image' => 'assets/images/products/custom-tackle-pack.jpg', 'color' => 'from-sky-100 via-cyan-200 to-blue-950', 'short' => 'A starter spread of local tackle favorites.', 'description' => 'A practical pack of proven tackle options for inshore and nearshore fishing trips.'],
            ['name' => 'M&M Specialty Fishing Lure', 'slug' => 'mm-specialty-fishing-lure', 'category' => 'specialty-tackle', 'price' => 9.99, 'stock' => 100, 'sku' => 'MM-SPECIALTY-LURE', 'featured' => false, 'image' => 'assets/images/products/specialty-fishing-lure.jpg', 'color' => 'from-cyan-100 via-white to-sky-400', 'short' => 'Specialty lure option for custom tackle boxes.', 'description' => 'A versatile fishing lure built for practical saltwater use and easy tackle-box pairing.'],
        ];

        foreach ($products as $product) {
            $category = Category::where('slug', $product['category'])->firstOrFail();

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'short_description' => $product['short'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'sale_price' => null,
                    'stock' => $product['stock'],
                    'sku' => $product['sku'],
                    'image' => $product['image'],
                    'status' => 'active',
                    'color' => $product['color'],
                    'rating' => 5,
                    'specs' => ['Stock: Demo inventory', 'Status: Active', 'Custom options: Available'],
                    'featured' => $product['featured'],
                ]
            );
        }
    }
}
