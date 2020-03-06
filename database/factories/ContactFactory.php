<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Contact;
use App\User;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
            'user_id' => factory(User::class),
            'name' => $faker->name,
            'city' => $faker->city,
            'adress' => $faker->adress,
            'phone' => $faker->phone
    ];
});
