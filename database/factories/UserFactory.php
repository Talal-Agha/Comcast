<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\ProductType::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10)
    ];
});

$factory->define(App\Models\Product::class, function (Faker $faker) {
    foreach (range(0, 3) as $key => $value) {
        $detail_images[] = $faker->image('public/storage/products', 200, 240, 'technics');
    }
    return [
        'name' => $faker->text(10),
        'image' => $faker->image('public/storage/products', 200, 240, 'technics'),
        'price' => $faker->randomNumber(2),
        'detail_images' => $detail_images,
    ];
});
