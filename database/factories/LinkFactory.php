<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;
use Aza\Components\Math\NumeralSystem;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'key' => NumeralSystem::convertTo(time().rand(100,999), 62),
        'redirect_to' => "http://" . $faker->domainName,
        'count_redirect' => $faker->randomNumber(),
        'user_id' => 0
    ];
});
