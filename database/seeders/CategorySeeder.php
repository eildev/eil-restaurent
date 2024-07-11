<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategorys = [
            [
                'id' => 1,
                'name' => 'Sandwiches',
                'slug' => 'Sandwiches',
            ],
            [
                'id' => 2,
                'name' => 'Salads',
                'slug' => 'Salads',
            ],
            [
                'id' => 3,
                'name' => 'Burgers',
                'slug' => 'Burgers',
            ],
            [
                'id' => 4,
                'name' => 'Soups',
                'slug' => 'Soups',
            ],
            [
                'id' => 5,
                'name' => 'Pizzas',
                'slug' => 'Pizzas',
            ],
            [
                'id' => 6,
                'name' => 'Chicken',
                'slug' => 'Chicken',
            ],
        ];

        foreach ($productCategorys as $productCategory) {
            Category::create($productCategory);
        }
    }
}
