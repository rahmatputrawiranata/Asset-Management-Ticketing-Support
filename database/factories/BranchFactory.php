<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'cities_id' => $faker->numberBetween(1, 7),
        'name' => $faker->company,
        'code' => $faker->unique()->regexify('[A-Z]{3}'),
        'address' => $faker->address,
        'longitude' => $faker->longitude,
        'latitude' => $faker->latitude,
        'eos' => $faker->name,
        'eos_number' => '62' . $faker->numberBetween(11111111111, 99999999999),
        'pic' => $faker->name,
        'pic_number' => '62' . $faker->numberBetween(11111111111, 99999999999),
        'pic_ga' => $faker->name,
        'pic_number' => '62' . $faker->numberBetween(11111111111, 99999999999),
        'status' => 1,
        'user' => 'Auto Generated By System'
    ];
});
