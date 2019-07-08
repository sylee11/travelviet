<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model


{
    public function places()
    {
    	return $this->hasMany('App\Place');
    }
    public function cities ()
    {
    	return $this->belongsTo(City::class); 
    }
}
