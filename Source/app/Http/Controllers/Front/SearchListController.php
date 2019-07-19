<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\City;
use App\District;
use App\Place;
use App\Post;
use App\Rating;
use App\Photo;


use DB;

class SearchListController extends Controller
{
	public function searchlist ()
	{
		$category=Category::all();
		$city=City::all();
		$district=District::all();
		return view('pages.home',['category'=>$category,'district'=>$district,'city'=>$city]);
	}
	public function getCityList(Request $request)
	{
		$districts = DB::table("districts")
		->where("cities_id",$request->cities_id)
		->pluck("name","id");
		return response()->json($districts);
	}
	public function getList()
	{

		$place=Place::all();
		$category=Category::all();
		$city=City::all();
		$district=District::all();
		return view('pages.list_place',['place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);

	}
	public function postList(Request $request)
	{
		$post = DB::table('posts')
		->join('places','posts.place_id','=','places.id')
		->join('ratings', 'posts.id', '=', 'ratings.post_id')->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')
		->where([
			['category_id', '=', $request->category_id ],
			['districts_id','=', $request->districts_id],
		])
		
		->get();
		return view('pages.list_place',['post' => $post]);

	}
	public function getsearch()
	{
		$post=Post::all();
		$place=Place::all();
		$category=Category::all();
		$city=City::all();
		$district=District::all();
		return view('pages.search_list',['post'=>$post,'place'=>$place,'category'=>$category,'district'=>$district,'city'=>$city]);

	}
	public function postsearch(Request $request)
	{ 
		// $search = Input::get ( 'search' );
		$search = $request ->search;
		$rating=Rating::all();
		$place=Place::all();
		$photo=Photo::all();
		$post= DB::table('posts')
		->join('places','posts.place_id','=','places.id')
		->join('ratings', 'posts.id', '=', 'ratings.post_id')->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.describer','places.address', 'posts.title','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')

		->where([
			['places.name','LIKE','%'.$search.'%']
		])
		->orWhere ([
			['places.name', 'LIKE', '%' . $search . '%']
		] )
		->get();

		

		 return view('pages.search_list',['post' => $post],['rating'=>$rating],['place'=>$place],['photo'=>$photo]);
	}
	public function googlemap()
	{
		$place = DB::table('places')->get();
    	return view('pages.googlemap',compact('place'));
		// return view('pages.googlemap',['place'=>$place]);
	}
}
