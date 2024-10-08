<?php

namespace Modules\Shop\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Shop\Entities\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'sku' => fake()->isbn10,
            'type' => Product::SIMPLE,
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => fake()->randomFloat(2, 10, 1000),  
            'status' => Product::ACTIVE,  
            'publish_date' => now(),
            'excerpt' => fake()->text(),
            'body' => fake()->text(),
        ];
    }
}
