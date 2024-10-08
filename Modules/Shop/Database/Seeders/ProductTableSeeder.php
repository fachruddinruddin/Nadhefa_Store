<?php

namespace Modules\Shop\Database\Seeders;

use App\Models\User;
use Modules\Shop\Entities\Attribute;
use Modules\Shop\Entities\Category;
use Modules\Shop\Entities\Tag;
use Modules\Shop\Entities\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Shop\Entities\ProductAttribute;
use Modules\Shop\Entities\ProductInventory;

class ProductTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $user = User::first();

        Attribute::setDefaultAttributes();
        $this->command->info('Default attributes seeded.');
        $attributeWeight = Attribute::where('code', Attribute::ATTR_WEIGHT)->first();

        Category::factory()->count(10)->create();
        $this->command->info('Category seeded.');
        $randomCategoryIds = Category::all()->random()->limit(2)->pluck('id');

        Tag::factory()->count(10)->create();
        $this->command->info('Tags seeded.');
        $randomTagIds = Tag::all()->random()->limit(2)->pluck('id');

        for ($i = 0; $i < 10; $i++) {
            $manageStock = (bool)random_int(0, 1);

            $product = Product::factory()->create([
                'user_id' => $user->id,
                'manage_stock' => $manageStock,
            ]);

            $product->categories()->sync($randomCategoryIds);
            $product->tags()->sync($randomTagIds);

            ProductAttribute::create([
                'product_id' => $product->id,
                'attribute_id' => $attributeWeight->id,
                'integer_value' => random_int(200, 2000),
            ]);

            if ($manageStock) {
                ProductInventory::create([
                    'product_id' => $product->id,
                    'qty' => random_int(3, 20),
                    'low_stock_threshold' => random_int(1, 3),
                ]);
            }
        }
        $this->command->info('10 sample product seeded.');
    }
}
