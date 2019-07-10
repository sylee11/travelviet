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
	public function detail($id){
		//return $id;
	/*	$photos= \App\Photo::where('post_id','=',$id)->get();
		return $photos->photo_path;
		//var_dump($photos);
		$posts = Post::where('id','=',$id)->get();
		$data['photos']=$photos;
		$data['posts']=$posts;
		//return view('pages/detail',['photos'=>$photos,'posts'=>$posts]);*/
		$data = DB::table('posts')
		->join('photos', 'posts.id', '=', 'photos.post_id')
		->join('users', 'posts.user_id', '=', 'users.id')
		->join('places','posts.place_id','=','places.id')
		->join('ratings','posts.id','=','ratings.post_id')
		->join('users as userscmt','ratings.user_id','=','userscmt.id')
		->select('posts.title','posts.describer', 'photos.photo_path', 'users.name','places.name as place','ratings.cmt','userscmt.name as cmtname','userscmt.avatar')
		->where('posts.id','=',$id)
		->get();
/*		$data =DB::table('ratings')
		->join('users','ratings.user_id','=','users.id')
		->select('users.name as usercmt','users.avatar')
		->where('ratings.post_id','=',$id)
		->union($data2)
		->get();*/
		$rating = DB::table('ratings')
                ->where('post_id', $id)
				->avg('rating');
				
		//$rating=\DB::raw('avg(ratings.rating) as avg_rating')->;
//echo $rating;return;
$data[0]->rating=$rating;
//$photo_path = $data->unique('photo_path')->values(); 

//		print_r($photo_path);
//		return;
		return view('pages/detail',['data'=>$data]);
	}
}
