<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Xoshbin\Inbox\Models\InboxEmail;
use Faker\Generator as Faker;

$factory->define(InboxEmail::class, function (Faker $faker) {
    return [
        'subject' => $faker->words(10),
        'to' => $faker->email,
        'from' => $faker->email,
        'body' => $faker->paragraph,
    ];
});
