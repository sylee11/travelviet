<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Rating;
use DB;
class FrontController extends Controller
{
	public function index(){
		$new_post= Post::orderBy('id', 'desc')->take(3)->get();
		 $rating=Rating::orderBy('rating','desc')->take(3)->get();
		 $top_user=Post::select('user_id', \DB::raw('count(id) as amount'))->groupBy('user_id')->orderBy('amount','desc')->take(4)->get();
		 foreach ($new_post as $value) {
		 	 $rat =Rating::where('post_id', '=', $value->id)->get();
		 }

		 return view('pages.index',['a'=>$rat,'rating'=>$rating,'top_user'=>$top_user]);
	}
}
