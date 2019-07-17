<?php

namespace App\Http\Controllers\rating;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Rating;
use App\Post;
use Illuminate\Validation\Rule;
use Response;
class RatingController extends Controller
{
	public function index()
	{
		$rating= Rating::all();
		$user=User::where('status','=','1')->get();
		$post=Post::where('is_approved','=','1')->get();
		return view('admin.rating.index',['rating'=>$rating,'user'=>$user,'post'=>$post]);
	}
	public function add(Request $request)
	{
		$this->validate($request, [
			'rating' => 'required',
			'comment' => 'required',
		]);

		$record = new Rating();
		$record->user_id=$request->user_id;
		$record->rating=$request->rating;
		$record->post_id=$request->post_id;
		$record->cmt=strip_tags($request->get('comment'));
		if($request->get('rating') > '5' || $request->get('rating') < '0'){
			return back()->with("error1","Rating between 0 and 5 !");
		}
		$record->save();
		return redirect('admin/rating')->with("success","Rating added success !");
	}
	public function edit($id){
		$show= Rating::find($id);
		$user=User::get();
		$post=Post::get();
		return view('admin.rating.edit',['show'=>$show,'user'=>$user,'post'=>$post]);
	}
	public function update(Request $request, $id){
		$rating= Rating::find($id);
		$rating->user_id = $request->get('user_id');
		$rating->rating = $request->get('rating');
		$rating->post_id = $request->get('post_id');
		$rating->cmt = strip_tags($request->get('comment'));
		if($request->get('rating') > '5' || $request->get('rating') < '0'){
			return back()->with("error1","Rating between 0 and 5 !");
		}
		if($request->get('comment') == NULL){
			return back()->with("error2","Comment not null !");
		}
		$rating->save();
		return redirect('admin/rating')->with("success","Rating updated success !");

	}
	public function delete($id){
		$rating= Rating::find($id);
		//dd($rating);
		$rating->delete();
		return redirect('admin/rating')->with("success","Rating deleted success !");
	}
}
