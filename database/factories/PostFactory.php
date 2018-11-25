<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {

    $title=$faker->sentence(4);//crea un palabra de 4 dijitos
    return [
        'user_id'=> rand(1,30),
        'category_id'=>rand(1,20),
       	'name'=>$title,
       	'slug'=>str_slug($title),
       	'excerpt'=>$faker->text(200),//crear información falsa
        'body'=>$faker->text(500),//crear información falsa
        'file'=>$faker->imageUrl($width=1200,$height=400),//crear información falsa
        'status'=>$faker->randomElement(['DRAFT','PUBLISHED']),

    ];
});

