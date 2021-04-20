<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'        => $faker->catchPhrase,
        'price_pence' => rand(2, 50) * 100 + rand(0, 99),
    ];
});
