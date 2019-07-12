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
class FrontController extends Controller
{
	public function index()
	{
		//show top users
		$top_user = Post::select('user_id', \DB::raw('count(id) as amount'))->groupBy('user_id')->orderBy('amount', 'desc')->take(4)->where('is_approved', '=', '1')->get();

		//show posts have rating highest
		$rating = Rating::select('post_id', \DB::raw('avg(rating) as avg_rating'))->orderBy('avg_rating', 'desc')->groupBy('post_id')->take(3)->get();
		//show post newest
		$new_post = Post::leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id', 'title', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->take(3)->get();

		$all_post = Post::leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id', 'title', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->get();
		//dd($new_post);
		return view('pages.index', ['new_post' => $new_post, 'rating' => $rating, 'top_user' => $top_user, 'all_post' => $all_post]);
	}
	public function detail($post_id)
	{

		$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->join('ratings', 'posts.id', '=', 'ratings.post_id')
			->join('users as userscmt', 'ratings.user_id', '=', 'userscmt.id')
			->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place','places.lat','places.longt', 'ratings.cmt', 'ratings.rating as rate', 'userscmt.name as cmtname', 'userscmt.avatar')
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
		//var_dump($user_rate);
		//return;
		return view('pages/detail', ['data' => $data, 'rating' => $rating, 'user_rate' => $user_rate]);
	}
	public function rate(Request $request)
	{

		$rating = $request->get('rating');
		$cmt = $request->get('commentarea');
		$user_id = $request->get('user_id');
		$post_id = $request->get('post_id');
		$user_rate = DB::table('ratings')->where('user_id', $user_id)->first();

		
		if ($user_rate === NULL) {
			/*DB::table('ratings')->insert(
				['cmt' => $cmt, 'rating' => $rating, 'user_id' => $user_id, 'post_id' => $post_id]
			);*/
			$rate = new Rating;
			$rate->cmt=$cmt;
			$rate->rating = $rating;
			$rate->user_id =$user_id;
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
			$rate = new Rating;
			$rate->cmt=$cmt;
			$rate->rating = $rating;
			$rate->user_id =$user_id;
			$rate->post_id = $post_id;
			$rate->save();
		}
		return $this->detail($post_id);
	}
	public function upgrade(Request $request){
		$user= Auth::user();
		$user->role = '2';

		$user->save();
		return redirect('/');

	}
}
