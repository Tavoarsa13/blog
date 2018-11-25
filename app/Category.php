<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   	protected $filliable=[
   	
		'name','slug','body'
	];
	protected $guarded = ['id'];

	
    public function posts(){

    	return $this->hasMany(Post::class);
    }
}
