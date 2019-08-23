<?php

namespace App;
use App\User;
use App\Place;
use App\Photo;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    //
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function photos()
    {
    	return $this->hasMany('App\Photo');
    }
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }
}

