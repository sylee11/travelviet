<?php

namespace App\Http\Controllers\rating;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Rating;
use App\Post;
class RatingController extends Controller
{
	public function index()
	{
		$rating= Rating::select('*')
		->join('users', 'users.id', '=', 'ratings.user_id')
		->select('ratings.*', 'users.name')
		->get();
		$user=User::select('*')->get();
		$post=Post::select('*')->get();
		return view('admin.rating.index',['rating'=>$rating,'user'=>$user,'post'=>$post]);
	}
	public function add(Request $request)
	{
		$record = new Rating();
		$record->user_id=$request->user_id;
		$record->rating=$request->rating;
		$record->post_id=$request->post_id;
		$record->cmt=$request->comment;
		$record->save();

		return redirect('admin/rating');
	}
	public function edit($id){
		$show= Rating::select('*')
		->join('users', 'users.id', '=', 'ratings.user_id')
		->select('ratings.*', 'users.name')
		->where('user_id',$id)
		->first();
		$user=User::select('*')->get();
		$post=Post::select('*')->get();
		return view('admin.rating.edit',compact('show','user','post'));
	}
}
