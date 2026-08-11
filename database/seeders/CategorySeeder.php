<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Blenders', 'slug' => 'blenders', 'sort_order' => 1, 'image' => 'categories/IMG_3104.jpg'],
            ['name' => 'Food Processors', 'slug' => 'food-processors', 'sort_order' => 2, 'image' => 'categories/IMG_3115.jpg'],
            ['name' => 'Juicers', 'slug' => 'juicers', 'sort_order' => 3, 'image' => 'categories/IMG_7850.jpg'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
