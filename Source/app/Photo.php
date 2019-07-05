<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    public function post(){

    	return $this->belongsTo(app\Post);
    }
}
