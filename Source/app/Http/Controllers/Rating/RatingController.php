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
use App\Rules\inputRating;

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
			'name_se' => 'required',
			'rating' =>  ['required','integer', new inputRating],
			'title' => 'required',
			'comment' => 'required',
		]);
		//dd("hello");
		$record = new Rating();
		$record->user_id=$request->user_id;
		$record->rating=$request->rating;
		$record->post_id=$request->post_id;
		$record->cmt=$request->comment;

		$record->save();
		return redirect('admin/rating')->with("success","Rating added success !");
	}
	public function edit($id){
		$show= Rating::find($id);
		$user=User::get();
		$post=Post::get();
		return view('admin.rating.edit',['show'=>$show,'user'=>$user,'post'=>$post]);
	}
	public function select(Request $request){
		$name= $request->get('query2');
		$title= $request->get('query');

		$user=User::where('name','LIKE','%'.$name.'%')->get();
		$post=Post::where('title','LIKE','%'.$title.'%')->get();

		return response()->json(['user'=>$user,'post'=>$post]);
	}
	public function update(Request $request, $id){
		$this->validate($request, [
			'name_se' => 'required',
			'rating' => ['required','integer', new inputRating],
			'title' => 'required',
			'comment' => 'required',
		]);
		$rating= Rating::find($id);
		$rating->user_id = $request->get('user_id');
		$rating->rating = $request->get('rating');
		$rating->post_id = $request->get('post_id');
		$rating->cmt = $request->get('comment');
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
