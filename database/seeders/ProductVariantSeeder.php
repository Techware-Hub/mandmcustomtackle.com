<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $variantProductSlugs = [
            'mm-custom-jig',
            'sarasota-snook-jig',
            'flare-hawk-jig',
            'bucktail-jig',
            'pompano-jig',
        ];

        Product::whereIn('slug', $variantProductSlugs)->get()->each(function (Product $product) {
            foreach (ProductVariant::DEFAULT_COLORS as $color) {
                foreach (ProductVariant::DEFAULT_WEIGHTS as $weight => $price) {
                    $product->variants()->updateOrCreate(
                        ['color_name' => $color, 'weight' => $weight],
                        [
                            'price' => $price,
                            'sku' => $product->sku.'-'.strtoupper(str_replace([' ', '/', '&'], '-', $color.'-'.$weight)),
                            'stock' => 100,
                            'status' => 'active',
                        ]
                    );
                }
            }
        });
    }
}
