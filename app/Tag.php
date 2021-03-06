<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    	protected $filliable=[
		'name','slug'
	];
	protected $guarded = ['id'];

	
    public function posts(){

    	return $this->belongsToMany(Post::class);
    }
}
