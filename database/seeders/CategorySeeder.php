<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Support\SiteData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        collect(SiteData::categories())->each(fn (array $category) => Category::updateOrCreate(
            ['slug' => $category['slug']],
            $category
        ));
    }
}
