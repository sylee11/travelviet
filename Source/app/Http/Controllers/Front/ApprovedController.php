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
use App\Photo;
class ApprovedController extends Controller
{
	public function show()
	{
		//show top users
		$id = Auth::id();
		$post = Post::where('is_approved', 0)->get();
		// foreach ($post as $s) {
		// 	# code...
		// 			$sa = $s->photos;
		// 			foreach ($sa as $ka) {
		// 				echo $ka->photo_path;
		// 				echo "</br>";

		// 			}

		// }
		// var_dump($post->photos);
		// return;
		//dd($post);
		//$photo = Photo::all();

		$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place')
			->where('posts.is_approved', '=', 0)
			->get();
		return view('pages.approvedPost',['data' =>$data, 'post'=>$post]);

//		dd($data);

	}
	public function approved($id){
		$data = Post::where('id', $id)->first();
		if($data){
			if($data->is_approved == 0){
				$data->is_approved = 1;
				$data->save();
			}
			else{
			$data->is_approved = 0;
			$data->save();
			}
		}
		return back();
	}

	public function delete($id){
		$data = Post::where('id', $id)->first()->delete();
		return back();
	}

	public function allpost(Request $request){
		$selec = $request->chose;
		$search = $request->search;
		$chose = $request ->chose2;
		//dd($selec);
		if($request->chose == "Tất cả bài viết"){
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
				->where('photos.flag' ,'=', 1)
				->Paginate(20);
			return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose , 'search' => $search]);

		}
		elseif ($request->chose == "Bài viết chưa duyệt") {
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
				->where('posts.is_approved', '=' , 0)
				->where('photos.flag' ,'=', 1)
				->Paginate(20);
			return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

		}
		elseif ($request->chose == "Bài viết đã duyệt") {
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
				->where('posts.is_approved', '=' , 1)
				->where('photos.flag' ,'=', 1)
				->Paginate(20);
			return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

		}
			// dd($data);
		$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
				->where('photos.flag' ,'=', 1)
				->Paginate(20);
			return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);
	}
	public function search(Request $request){
		$search = $request ->search;
		$chose = $request ->chose2;
		$selec = $request->chose;
		// dd($search == '');
		if($search == ''){
			if($chose == 'Actor' &&  $selec == 'Tất cả bài viết')
			{
				// dd($selec);
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Actor' &&  $selec == 'Bài viết đã duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('posts.is_approved', '=' , 1)
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Actor' &&  $selec == 'Bài viết chưa duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('posts.is_approved', '=' , 0)
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}

			if($chose == 'Địa điểm' &&  $selec == 'Tất cả bài viết')
			{
				// dd($selec);
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Địa điểm' &&  $selec == 'Bài viết đã duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('posts.is_approved', '=' , 1)
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Địa điểm' &&  $selec == 'Bài viết chưa duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('posts.is_approved', '=' , 0)
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
		}
		else{
			if($chose == 'Actor' &&  $selec == 'Bài viết chưa duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['users.name','like', "%".$search."%"],
						['posts.is_approved', '=' , 0]

					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Actor' &&  $selec == 'Bài viết đã duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['users.name','like', "%".$search."%"],
						['posts.is_approved', '=' , 1]

					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Địa điểm' &&  $selec == 'Bài viết chưa duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['users.name','like', "%".$search."%"],
						['posts.is_approved', '=' , 0]

					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Địa điểm' &&  $selec == 'Bài viết đã duyệt')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['users.name','like', "%".$search."%"],
						['posts.is_approved', '=' , 1]

					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}

			if($chose == 'Địa điểm' &&  $selec == 'Tất cả bài viết')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['posts.title','like', "%".$search."%"],
					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			if($chose == 'Actor' &&  $selec == 'Tất cả bài viết')
			{
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where([
						['users.name','like', "%".$search."%"],
					])
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);

			}
			elseif ($chose == 'Địa điểm') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.id', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'posts.is_approved')
					->where('posts.title','like', "%".$search."%")
					->where('photos.flag' ,'=', 1)
					->Paginate(20);
					return view('pages.showAllPost', ['data' => $data , 'selec' => $selec,'chose' => $chose, 'search' => $search]);
			}
		}
	}

	public function appcetall(){
		$data = Post::where('is_approved', 0)->get();
		foreach ($data as $da) {
			$da->is_approved = 1;
			$da->save();
		}
		return back();
	}
	public function unappcetall(){
		$data = Post::where('is_approved', 1)->get();
		foreach ($data as $da) {
			$da->is_approved = 0;
			$da->save();
		}
		return back();
	}
}
