<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
	$title=$faker->sentence(4);//crea un palabra de 4 dijitos
    return [
        'name'=> $title,
        'slug'=>str_slug($title),
        'body'=>$faker->text(10000),//crear información falsa
    ];
});
