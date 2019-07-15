<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Rating;
use DB;
use App\User;
use Auth;
use Response;
use App\City;
class FrontController extends Controller
{
	public function index(){
		//show top users
		$top_user=Rating::select('user_id', \DB::raw('count(id) as amount'))->groupBy('user_id')->orderBy('amount','desc')->take(4)->get();

		//show posts have rating highest
		$top_rating=Post::join('ratings', 'posts.id', '=', 'ratings.post_id')->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id', 'posts.title','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('avg_rating','desc')->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->where('is_approved','=','1')->where('photos.flag','=','1')->take(4)->get();
		//dd($top_user);
		//show post newest
		$new_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id','title','photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->groupBy('photos.photo_path')->where('is_approved','=','1')->where('photos.flag','=','1')->take(4)->get();

		$all_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id','title','photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->groupBy('photos.photo_path')->where('is_approved','=','1')->where('photos.flag','=','1')->get();

		$cities=Post::join('places', 'posts.place_id', '=', 'places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->select('cities.id', \DB::raw('count(posts.id) as sum'))
		->orderBy('sum', 'desc')
		->groupBy('cities.id')
		->where('is_approved','=','1')->take(3)->get();
		//dd($cities);
		$array=array();
		foreach ($cities as $value) {
			$tt=Post::join('places', 'posts.place_id', '=', 'places.id')
			->join('districts', 'places.districts_id', '=', 'districts.id')
			->join('cities', 'districts.cities_id', '=', 'cities.id')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->select('photos.photo_path','cities.name')
			->where('cities.id','=',$value->id)
			->where('is_approved','=','1')
			->where('photos.flag','=','1')
			->first();
			array_push($array,$tt);
		}
		// foreach ($array as $value) {
		// 	echo $value;
		// }

		return view('pages.index',['new_post'=>$new_post,'top_rating'=>$top_rating,'top_user'=>$top_user,'all_post'=>$all_post,'city'=>$array]);
	}

	public function upgrade(Request $request){
		$user= Auth::user();
		$user->role = '2';

		$user->save();
		return redirect('/');

	}
}
