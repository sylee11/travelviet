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
use App\User;
use Auth;
use Response;


use DB;

class FrontController extends Controller
{
	public function index()
	{
		$category = Category::all();
		$city = City::all();
		$district = District::all();
		//show top users

		$user = User::join('posts', 'posts.user_id', '=', 'users.id')
		->select('posts.user_id', \DB::raw('count(posts.id) as amount'))
		->orderBy('amount', 'desc')
		->groupBy('posts.user_id')
		->take(4)
		->get();
		$top_user = array();
		foreach ($user as $value) {
			$top = User::where('id', '=', $value->user_id)->first();
			array_push($top_user, $top);
		}
		//dd($top_user);
		//show posts have rating highest
		$top_rating = Post::join('ratings', 'posts.id', '=', 'ratings.post_id')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->select('posts.id', 'posts.title', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('avg_rating', 'desc')
		->groupBy('posts.id')
		->groupBy('posts.title')
		->groupBy('photos.photo_path')
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->take(4)
		->get();
		//dd($top_user);
		//show post newest
		$new_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->take(6)
		->get();

		$all_post = Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->take(12)
		->get();

		$cities = Post::join('places', 'posts.place_id', '=', 'places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->select('cities.id', \DB::raw('count(posts.id) as sum'))
		->orderBy('sum', 'desc')
		->groupBy('cities.id')
		->where('is_approved', '=', '1')->take(6)->get();
		//dd($cities);
		//dd($cities);
		$array = array();
		foreach ($cities as $value) {
			$tt = Post::join('places', 'posts.place_id', '=', 'places.id')
			->join('districts', 'places.districts_id', '=', 'districts.id')
			->join('cities', 'districts.cities_id', '=', 'cities.id')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->select('photos.photo_path', 'cities.name', 'cities.id')
			->where('cities.id', '=', $value->id)
			->where('is_approved', '=', '1')
			->where('photos.flag', '=', '1')
			->first();
			array_push($array, $tt);
		}
		//dd($array);

		return view('pages.index', ['new_post' => $new_post, 'top_rating' => $top_rating, 'top_user' => $top_user, 'all_post' => $all_post, 'city_post' => $array, 'category' => $category, 'district' => $district, 'city' => $city]);
	}

	public function allPosts(){
		$all_posts = Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->paginate(15);

		return view('pages.allPost',['all_posts'=>$all_posts]);
	}
	public function searchPost(Request $request){
		$search = $request->search;
		$post= Post::join('photos', 'posts.id', '=', 'photos.post_id')
		->leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'title', 'photos.photo_path', \DB::raw('avg(ratings.rating) as avg_rating'))
		->orderBy('posts.id', 'desc')
		->groupBy('posts.id')
		->groupBy('title')
		->groupBy('photos.photo_path')
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->where('title', 'like' , "%".$request->search."%")
		->paginate(15);
    	return view('pages.allPost', ['all_posts' => $post, 'search' => $search]);

	}

	public function detail($post_id)
	{

		$data = DB::table('posts')

		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->join('places', 'posts.place_id', '=', 'places.id')
		->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->leftJoin('users as userscmt', 'ratings.user_id', '=', 'userscmt.id')
		->select('posts.id', 'posts.place_id', 'posts.title', 'posts.user_id', 'posts.describer', 'posts.created_at', 'photos.photo_path', 'users.name', 'places.name as place', 'places.lat', 'places.longt', 'ratings.cmt', 'ratings.rating as rate', 'ratings.created_at', 'userscmt.id as cmtid', 'userscmt.name as cmtname', 'userscmt.avatar')
		->where('posts.id', '=', $post_id)
		->get();

		$rating = DB::table('ratings')
		->where('post_id', $post_id)
		->avg('rating');
		$rating = number_format($rating, 1);
		$user_id = \Auth::id();
		$user_rate =  DB::table('ratings')->select('rating')->where([
			['user_id', '=', $user_id],
			['post_id', '=', $post_id],
		])->orderBy('id', 'desc')->first();
		session()->put('link',  url()->current());
		//var_dump($data);
		//return;
		//dd($data);
		$data2 = DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('places', 'posts.place_id', '=', 'places.id')
		->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
		->select('posts.id', 'posts.title', 'photos.photo_path')
		->where([
			['posts.place_id', '=', $data[0]->place_id],
			['photos.flag', '=', 1],
			['posts.id', '<>', $post_id]

		])
		->distinct()
		->take(4)
			//->avg('ratings.rating')
		->get();
		foreach ($data2 as $key => $value) {
			$value->rate = DB::table('ratings')
			->where('post_id', $value->id)
			->avg('rating');
		}

		//dd($data2);

		return view('pages/detail', ['data' => $data, 'rating' => $rating, 'user_rate' => $user_rate,'post_relate'=>$data2]);
	}
	public function rate(Request $request)
	{

		$rating = $request->get('rating');
		$cmt = $request->get('commentarea');
		$user_id = $request->get('user_id');
		$post_id = $request->get('post_id');
		$user_rate = DB::table('ratings')->where('user_id', $user_id)->first();

		$rate = new Rating;
		if ($user_rate === NULL) {
			/*DB::table('ratings')->insert(
				['cmt' => $cmt, 'rating' => $rating, 'user_id' => $user_id, 'post_id' => $post_id]
			);*/
			//$rate = new Rating;
			$rate->cmt = $cmt;
			$rate->rating = $rating;
			$rate->user_id = $user_id;
			$rate->post_id = $post_id;
			$rate->save();
		} else {

			DB::table('ratings')->where([
				['user_id', '=', $user_id],
				['post_id', '=', $post_id],
			])->update(['rating' => null]);
			/*	DB::table('ratings')->insert(
				['cmt' => $cmt, 'rating' => $rating, 'user_id' => $user_id, 'post_id' => $post_id]
			);*/
			//$rate = new Rating;
			$rate->cmt = $cmt;
			$rate->rating = $rating;
			$rate->user_id = $user_id;
			$rate->post_id = $post_id;
			$rate->save();
		}
		//return $this->detail($post_id);

		return back();
	}
	public function upgrade(Request $request)
	{
		$user = Auth::user();
		$user->role = '2';

		$user->save();
		return redirect('/');
	}

	public function showPosts($id)
	{
		$post_city = Post::join('places', 'posts.place_id', '=', 'places.id')
		->join('districts', 'places.districts_id', '=', 'districts.id')
		->join('cities', 'districts.cities_id', '=', 'cities.id')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->where('cities.id', '=', $id)
		->where('is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->paginate(5);
		$name_city = City::where('id', '=', $id)->first();
		//dd($post_city);
		return view('pages.postsCity', ['post_city' => $post_city, 'name_city' => $name_city]);
	}
	public function userInfo($user_id)
	{
		$data = DB::table('users')->find($user_id);
		return view('pages/userInfo', ['data' => $data]);
	}
	public function userPost($user_id)
	{
		$data = \DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->select('posts.id as post_id', 'posts.title', 'posts.describer', 'posts.created_at', 'posts.is_approved', 'photos.photo_path', 'users.name')
		->where('posts.user_id', '=', $user_id)
		->where('posts.is_approved', '=', '1')
		->where('photos.flag', '=', '1')
		->orderBy('posts.id', 'desc')
		->paginate(5);
		//var_dump($data->count());
		//return;
		//	if($data->count() !==0)
		return view('pages/userpost', ['data' => $data]);
		//	else return back()->withErrors('msg','ko co post');
	}
	public function userComment($user_id)
	{
		$data = \DB::table('ratings')
		->join('posts', 'ratings.post_id', '=', 'posts.id')
		->join('users', 'ratings.user_id', '=', 'users.id')
		->select('ratings.id', 'ratings.cmt', 'ratings.created_at', 'ratings.rating', 'posts.id as post_id', 'posts.title', 'users.name')
		->where('ratings.user_id', '=', $user_id)->get();
		return view('pages/mycmt', ['data' => $data]);
	}
}
