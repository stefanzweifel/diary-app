<?php

use App\Entry;
use App\Journal;
use App\User;
use Faker\Generator;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Journal::class, function(Generator $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'title' => $faker->name
    ];
});

$factory->define(Entry::class, function(Generator $faker) {
    return [
        'content' => $faker->text,
        'journal_id' => factory(Journal::class)->create()->id,
        'user_id' => factory(User::class)->create()->id
    ];
});