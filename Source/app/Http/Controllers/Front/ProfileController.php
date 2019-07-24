<?php


namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Image;
use Redirect;
use URL;
use Response;
use App\Post;

class ProfileController extends Controller
{
	public function show()
	{
		return view('pages.profile');
	}
	public function edit()
	{
		return view('pages.editProfile');
	}
	public function update(Request $request)
	{
		$user = Auth::user();
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		$user->birthday = $request->get('birthday');
		$user->address = $request->get('address');
		$user->phone = $request->get('phone');
		//dd($user->avatar);
		$user->save();
		return redirect('profile');
	}
	public function update_avatar(Request $request)
	{
		if ($request->has('avatar')) {
			$user = Auth::user();
			$avatar = $request->avatar;
			$avatarName = "/picture/avatar/" . $request->avatar->getClientOriginalName();
			Image::make($avatar)->save(public_path($avatarName));
			$user->avatar = $avatarName;
			$user->save();
		}
		return redirect('edit');
	}
	public function mypost()
	{
		$id = Auth::id();
		$data = Post::join('photos', 'photos.post_id', '=', 'posts.id')
		->where('posts.user_id', '=', $id)
		->where('photos.flag', '=', '1')
		->orderBy('posts.id', 'desc')
		->paginate(5);

		return view('pages/mypost', ['data' => $data]);
	}
	public function mycomment()
	{
		$id = Auth::id();

		$data = \DB::table('ratings')
		->join('posts', 'ratings.post_id', '=', 'posts.id')
		->select('ratings.id', 'ratings.cmt', 'ratings.rating', 'posts.id', 'posts.title')
		->where('ratings.user_id', '=', $id)->get();
		return view('pages/mycmt', ['data' => $data]);

	}
}
