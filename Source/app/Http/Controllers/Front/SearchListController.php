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
	
	public function getList(Request $request)
	{   
		
		
		if($request->cities_id =='' && $request->districts_id =='Quận,huyện' && $request->category_id =='')
		{
			$post = DB::table('posts')
			->join('places','posts.place_id','=','places.id')
			->join('districts','places.districts_id','=','districts.id')
			->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')
			->where([
				['photos.flag', '=', '1'],
				['is_approved','=','1']
			])
			->Paginate(10);
					// ->get();
			return view('pages.list_place',['post' => $post]);
		}

		elseif($request->cities_id !='')
		{

			if($request->districts_id !='Quận,huyện')
			{
				if($request->category_id !='')
				{
					$post = DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts','places.districts_id','=','districts.id')
					->join('cities','districts.cities_id','=','cities.id')
					->join('categories','places.category_id','=','categories.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')

					->where([
						['photos.flag', '=', '1'],
						['is_approved','=','1'],
						['category_id','=', $request->category_id],
						['districts_id','=', $request->districts_id]
					])
					->Paginate(10);
					// ->get();

					return view('pages.list_place',['post' => $post]);
				}
				else{
					$post = DB::table('posts')
					->join('places','posts.place_id','=','places.id')
					->join('districts','places.districts_id','=','districts.id')
					->join('cities','districts.cities_id','=','cities.id')
					->join('categories','places.category_id','=','categories.id')
					->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')
					
					->where([
						['photos.flag', '=', '1'],
						['is_approved','=','1'],
						['cities_id','=', $request->cities_id],
						['districts_id','=', $request->districts_id]
					])
					// ->get();
					->Paginate(10);
					return view('pages.list_place',['post' => $post]);
				}
			}
			elseif($request->cities_id !='' && $request->districts_id =='Quận,huyện' && $request->category_id =='')
			{
				$post = DB::table('posts')
				->join('places','posts.place_id','=','places.id')
				->join('districts','places.districts_id','=','districts.id')
				->join('cities','districts.cities_id','=','cities.id')
				->join('categories','places.category_id','=','categories.id')
				->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')

				->where([
					['photos.flag', '=', '1'],
					['is_approved','=','1'],
					['cities_id','=', $request->cities_id]
				])

				// ->get();
				->Paginate(10);

				return view('pages.list_place',['post' => $post]);
			}
			elseif($request->cities_id !='' && $request->districts_id =='Quận,huyện' && $request->category_id !='')
			{
				$post = DB::table('posts')
				->join('places','posts.place_id','=','places.id')
				->join('districts','places.districts_id','=','districts.id')
				->join('cities','districts.cities_id','=','cities.id')
				->join('categories','places.category_id','=','categories.id')
				->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')
				
				->where([
					['photos.flag', '=', '1'],
					['is_approved','=','1'],
					['cities_id','=', $request->cities_id],
					['category_id','=', $request->category_id],
				])

				// ->get();
				->Paginate(10);

				return view('pages.list_place',['post' => $post]);
			}

			
		}

		elseif($request->category_id !='')
		{
			$post = DB::table('posts')
			->join('places','posts.place_id','=','places.id')
			->join('districts','places.districts_id','=','districts.id')
			->join('cities','districts.cities_id','=','cities.id')
			->join('categories','places.category_id','=','categories.id')
			->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->select('posts.id', 'posts.title','posts.describer','places.address','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')->groupBy('posts.describer')->groupBy('places.address')

			->where([
				['photos.flag', '=', '1'],
				['is_approved','=','1'],
				['category_id','=', $request->category_id]
			])
			->where('photos.flag', '=', '1')
			// ->get();
			->Paginate(10);

			return view('pages.list_place',['post' => $post]);
		}



	}
	public function getsearch(Request $request)
	{

		$search = $request ->search;

		$post= DB::table('posts')
		->join('places','posts.place_id','=','places.id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->join('photos', 'posts.id', '=', 'photos.post_id')->select('posts.id','posts.describer','places.address', 'posts.title','photos.photo_path',\DB::raw('avg(ratings.rating) as avg_rating'))->groupBy('posts.id')->groupBy('posts.title')->groupBy('photos.photo_path')

		->where([
			['places.name','LIKE','%'.$search.'%']
		])
		->orWhere ([
			['places.address', 'LIKE', '%' . $search . '%']
		] )
			// ->get();
		->where('photos.flag', '=', '1')
		->Paginate(10);

		return view('pages.search_list',['post' => $post]);


	}
	
	public function googlemap()
	{
		$place = DB::table('places')->get();
		return view('pages.googlemap',compact('place'));
		// return view('pages.googlemap',['place'=>$place]);
	}
}
