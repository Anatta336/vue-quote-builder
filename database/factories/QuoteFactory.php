<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quote;
use Faker\Generator as Faker;

$factory->define(Quote::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->firstName . ' ' . $faker->lastName,
        'customer_email' => $faker->email,
    ];
});
