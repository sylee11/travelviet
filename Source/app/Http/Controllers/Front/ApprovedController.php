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
use File;
use Config;
use App\Notifications\AcceptPost;
use App\Notifications\CreatePost;
use Illuminate\Support\Facades\URL;

class ApprovedController extends Controller
{
	public function show($id)
	{

		$notifytable = DB::table('notifications')
			->select('data', 'type')
			->where('notifications.id', '=', $id)->first();

		$id_post = substr($notifytable->data, 11, strpos($notifytable->data, ',') - 11);
		//var_dump($id_post);return;
		/*if ($notifytable->type == 'App\Notifications\AcceptPost') {

			DB::table('notifications')
				->where('notifications.id', '=', $id)
				->delete();
			return redirect("/detail/$id_post");
		}*/
		DB::table('notifications')
			->where('notifications.id', '=', $id)
			->update(['read_at' => now()]);

		//$notification->markAsRead();
		//$id_post =$notification->data['post_id'];


		//	print($id_post);return;
		$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->select('posts.id', 'posts.title', 'posts.describer','posts.slug', 'photos.photo_path', 'users.name', 'places.name as place', 'users.id as user_id')
			->where('posts.id', '=', $id_post)
			->where('posts.is_approved', '=', 0)
			->where('photos.flag', '=', '1')
			->get();
		//var_dump($data);
		//	return;

		return view('pages.approvedPost', ['data' => $data]);

		//		dd($data);

	}
	public function approved($id)
	{
		if(Post::where('id', $id)->first() == null){
			return view('includes.erro404');
		}
		$data = Post::where('id', $id)->first();
		if ($data) {
			if ($data->is_approved == 0) {
				$data->is_approved = 1;
				$data->save();
			} else {
				$data->is_approved = 0;
				$data->save();
			}
		}

		DB::table('notifications')
			->where([
				['notifications.data', 'like', "{\"post_id\":$id%"],
				['notifications.type', '=', 'App\Notifications\CreatePost'],
			])
			->delete();

		$toUser = User::find($data->user_id);
		\Notification::send($toUser, new AcceptPost($data));
		//return back();
		$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid', 'posts.created_at as time')
			->orderby('postid','desc')
			->where('photos.flag', '=', 1)
			->paginate(Config::get('constant.pagenation')); 
		return view('pages.showAllPost', ['data' => $data, 'selec' => 'Tất cả bài viết', 'chose' => 'Actor', 'search' => '']);
	}

	public function delete(Request $request)
	{	//dd(strpos(URL::previous(),"admin/approved/show")!=false);
		$id= $request->iddelete;
		if(Post::where('id', $id)->first() == null){
			return view('includes.erro404');
		}
		$id= $request->iddelete;
		$data = Post::where('id', $id)->first()->delete();
		$path = "/picture/admin/post/" . $id;
		File::deleteDirectory(public_path($path));
		$Rating = Rating::where('post_id', $id)->delete();
		
		DB::table('notifications')
			->where([
				['notifications.data', 'like', "{\"post_id\":$id%"],
				['notifications.type', '=', 'App\Notifications\CreatePost'],
			])
			->delete();
		if(strpos(URL::previous(),"admin/approved/show") != false){
			$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid', 'posts.created_at as time')
			->orderby('postid','desc')
			->where('photos.flag', '=', 1)
			->paginate(Config::get('constant.pagenation'));
		return view('pages.showAllPost', ['data' => $data, 'selec' => 'Tất cả bài viết', 'chose' => 'Actor', 'search' => '']);
		}
		return back();
	}

	public function allpost(Request $request)
	{
		$selec = $request->chose;
		$search = $request->search;
		$chose = $request->chose2;
		//dd($selec);
		if ($request->chose == "Tất cả bài viết") {
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid', 'posts.created_at as time')
				->orderby('postid','desc')
				->where('photos.flag', '=', 1)
				->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);

			return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
		} elseif ($request->chose == "Bài viết chưa duyệt") {
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
				->orderby('postid','desc')
				->where('posts.is_approved', '=', 0)
				->where('photos.flag', '=', 1)
				->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
			return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
		} elseif ($request->chose == "Bài viết đã duyệt") {
			$data = DB::table('posts')
				->join('photos', 'posts.id', '=', 'photos.post_id')
				->join('users', 'posts.user_id', '=', 'users.id')
				->join('places', 'posts.place_id', '=', 'places.id')
				->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
				->orderby('postid','desc')
				->where('posts.is_approved', '=', 1)
				->where('photos.flag', '=', 1)
				->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
			return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
		}
		// dd($data);
		$data = DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users', 'posts.user_id', '=', 'users.id')
			->join('places', 'posts.place_id', '=', 'places.id')
			->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
			->orderby('postid','desc')
			->where('photos.flag', '=', 1)
			->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);

		return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
	}
	public function search(Request $request)
	{
		$search = $request->search;
		$chose = $request->chose2;
		$selec = $request->chose;
		// dd($search == '');
		if ($search == '') {
			if ($chose == 'Actor' &&  $selec == 'Tất cả bài viết') {
				// dd($selec);
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				$data->appends(['search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Actor' &&  $selec == 'Bài viết đã duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('posts.is_approved', '=', 1)
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Actor' &&  $selec == 'Bài viết chưa duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('posts.is_approved', '=', 0)
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}

			if ($chose == 'Địa điểm' &&  $selec == 'Tất cả bài viết') {
				// dd($selec);
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Địa điểm' &&  $selec == 'Bài viết đã duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('posts.is_approved', '=', 1)
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Địa điểm' &&  $selec == 'Bài viết chưa duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('posts.is_approved', '=', 0)
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
		} else {
			if ($chose == 'Actor' &&  $selec == 'Bài viết chưa duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['users.name', 'like', "%" . $search . "%"],
						['posts.is_approved', '=', 0]

					])
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Actor' &&  $selec == 'Bài viết đã duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['users.name', 'like', "%" . $search . "%"],
						['posts.is_approved', '=', 1]

					])
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Địa điểm' &&  $selec == 'Bài viết chưa duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['posts.title', 'like', "%" . $search . "%"],
						['posts.is_approved', '=', 0]

					])
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Địa điểm' &&  $selec == 'Bài viết đã duyệt') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['posts.title', 'like', "%" . $search . "%"],
						['posts.is_approved', '=', 1],
						['photos.flag', '=', 1]
					])
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}

			if ($chose == 'Địa điểm' &&  $selec == 'Tất cả bài viết') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['posts.title', 'like', "%" . $search . "%"],
					])
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
			if ($chose == 'Actor' &&  $selec == 'Tất cả bài viết') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where([
						['users.name', 'like', "%" . $search . "%"],
					])
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			} elseif ($chose == 'Địa điểm') {
				$data = DB::table('posts')
					->join('photos', 'posts.id', '=', 'photos.post_id')
					->join('users', 'posts.user_id', '=', 'users.id')
					->join('places', 'posts.place_id', '=', 'places.id')
					->select('posts.*', 'posts.title', 'posts.describer', 'photos.photo_path', 'users.name', 'places.name as place', 'users.*', 'posts.is_approved', 'posts.id as postid','posts.created_at as time')
					->orderby('postid','desc')
					->where('posts.title', 'like', "%" . $search . "%")
					->where('photos.flag', '=', 1)
					->paginate(Config::get('constant.pagenation')); $data->appends(['chose'=> $selec,'chose2' => $chose, 'search'=> $search]);
				return view('pages.showAllPost', ['data' => $data, 'selec' => $selec, 'chose' => $chose, 'search' => $search]);
			}
		}
	}

	public function appcetall()
	{
		$data = Post::where('is_approved', 0)->get();
		foreach ($data as $da) {
			$da->is_approved = 1;
			$da->save();
		}
		return back();
	}
	public function unappcetall()
	{
		$data = Post::where('is_approved', 1)->get();
		foreach ($data as $da) {
			$da->is_approved = 0;
			$da->save();
		}
		return back();
	}
}
