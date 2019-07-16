<?php

namespace App;
use App\User;
use App\Place;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    //

    // protected $fillable = ['place_id'];
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function photos(){
    	return $this->hasMany('App\Photo');
    }
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}

