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
	public function index(){
		//show top users
		$top_user=Post::select('user_id', \DB::raw('count(id) as amount'))->groupBy('user_id')->orderBy('amount','desc')->take(4)->where('is_approved','=','1')->get();

		//show posts have rating highest
		$rating=Rating::select('post_id', \DB::raw('avg(rating) as avg_rating'))->orderBy('avg_rating','desc')->groupBy('post_id')->take(3)->get();
		//show post newest
		$new_post = Post::leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id','title', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->take(3)->get();

		$all_post = Post::leftjoin('ratings', 'posts.id', '=', 'ratings.post_id')->select('posts.id','title', \DB::raw('avg(ratings.rating) as avg_rating'))->orderBy('posts.id', 'desc')->groupBy('posts.id')->groupBy('title')->get();
		//dd($new_post);
		return view('pages.index',['new_post'=>$new_post,'rating'=>$rating,'top_user'=>$top_user,'all_post'=>$all_post]);
	}

	public function upgrade(Request $request){
		$user= Auth::user();
		$user->role = '2';

		$user->save();
		return redirect('/');

	}
}
