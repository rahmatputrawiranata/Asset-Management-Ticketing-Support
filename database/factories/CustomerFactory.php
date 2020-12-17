<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'username' => $faker->userName,
        'password' => Hash::make('password'),
        'email' => $faker->unique()->safeEmail,
        'phone' => '62'.$faker->unique()->numberBetween(11111111111,99999999999),
        'user' => 'Auto Generated By System'
    ];
});
