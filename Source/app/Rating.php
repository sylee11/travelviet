<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;

class Rating extends Model
{
	protected $table= 'ratings';
	protected $fillable = [
		'rating', 'user_id', 'cmt',
	];
	public function users()
	{
		return $this->belongsTo(User::class);
	}
	public function posts()
	{
		return $this->belongsTo(Post::class);
	}
}
