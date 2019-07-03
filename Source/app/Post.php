<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Place;

class Post extends Model
{
    public function users()
	{
		return $this->belongsTo(User::class);
	}
	public function places()
	{
		return $this->belongsTo(Place::class);
	}
}
