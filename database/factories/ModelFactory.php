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

    // $preHashedPassword = bcrypt('secret');
    $preHashedPassword = '$2y$10$5lGkea6X.I0.R/gUfdItWerLxkfhJNBk8W.5/DZTUcUGNLUF3NA72';

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = $preHashedPassword,
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'with_master_password', function ($faker) {

    // bcrypt('master-password')
    $masterPassword = '$2y$10$NNt6pEURH2KsBYOO98OB4e1ZT8KVqbLJJ4c4x02qFXEeMQ2pXw92y';

    // bcrypt(str_random(10))
    $encryptionKey = '$2y$10$VB5YJiWtap8T4DhBrJ7TGOC7447JgbEN6SFv/lzZP4vJUZP5m6WXe';

    return [
        'master_password' => $masterPassword,
        'encryption_key' => $encryptionKey
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
        'title' => $faker->sentence,
        'date' => $faker->date(),
        'content' => $faker->text,
        'journal_id' => factory(Journal::class)->create()->id,
        'user_id' => factory(User::class)->create()->id
    ];
});