<?php

namespace App;
use App\User;
use App\Place;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    //
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function photos(){
    	return $this->hasMany('App\Photo');
    }
    public function places()
    {
        return $this->belongsTo(Place::class);
    }
}

