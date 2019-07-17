<?php

namespace App;
use App\Post;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    public function post()
    {
    	return $this->belongsTo('App\Post');
    }
}
