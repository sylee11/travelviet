<?php

namespace App;
use App\Post;
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


    public function posts ()
    {
        return $this->hasMany(Post::class);

    }
}

