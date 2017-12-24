<?php

use Faker\Generator as Faker;
use App\Installment;

$factory->define(Installment::class, function (Faker $faker) {
    return [
        'value' => $faker->optional($weight = 0.95, $default = $faker->randomFloat(2, 500, 10000))->randomFloat(2, 0.01, 500),
        'deadline_date' => $faker->date(),
        'effective_date' => $faker->date(),
        'status' => $faker->randomElement(['effected', 'pending'])
    ];
});
