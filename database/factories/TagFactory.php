<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
   $title=$faker->unique()->word(5);//crea un palabra de 5 dijitos
    return [
        'name'=> $title,
        'slug'=>str_slug($title),
       
    ];
});
