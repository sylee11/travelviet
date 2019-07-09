<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function place()
    {
    	return $this->hasMany(Place::class);
    }
}
