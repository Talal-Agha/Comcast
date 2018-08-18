<?php

use Illuminate\Database\Seeder;

class ProductTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProductType::class, 5)->create()->each(function ($type) {
            $type->products()->save(factory(App\Models\Product::class)->make());
            $type->products()->save(factory(App\Models\Product::class)->make());
        });
    }
}
