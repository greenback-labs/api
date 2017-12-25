<?php

use Faker\Generator as Faker;
use App\Transaction;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'type' =>  $faker->randomElement(['in', 'out']),
        'value' => round($faker->optional($weight = 0.95, $default = $faker->randomFloat(2, 500, 10000))->randomFloat(2, 0.01, 500), 2),
        'title' => substr($faker->sentence(rand(2, 6)), 1, 250),
        'description' => substr($faker->optional($weight = 0.5)->paragraph(rand(1, 6)), 1, 1000),
        'date' => $faker->date()
    ];
});
