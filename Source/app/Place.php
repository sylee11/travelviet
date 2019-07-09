<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table ="places";
    public function category ()
    {
    	return $this->belongsTo(Category::class); 
    }
     public function districts ()
    {
    	return $this->belongsTo(District::class); 
    }
    //  public function city ()
    // {
    // 	return $this->belongsTo(City::class); 
    // }
}

