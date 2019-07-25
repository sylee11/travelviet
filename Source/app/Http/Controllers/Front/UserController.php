<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Post;
use App\Rating;
use App\Photo;
use File;
class UserController extends Controller
{
    public function show(){
    	$search = "";
    	$user = DB::table('users')
    	->select('users.*')
    	->Paginate(40);
    	return view('pages.userManager', ['user' => $user,'search' => $search]);
    }

    public function delete(Request $request){
    	$user = User::where('id',$request->id);
    	if($user->first()->role == 1){
    		return redirect()->back()->with('errro' , 'Ban khong the xoa admin');
    	}
    	$post = Post::where('user_id', $request->id);
        $postid = Post::where('user_id', $request->id)->get();
        foreach ($postid as $p) {
            # code...
            $photo = Photo::where('post_id', $p->id);
            $rating2 = Rating::where('post_id', $p->id);
            $path = "/picture/admin/post/".$p->id; 
            $rating2->delete();
            $photo->delete();
            File::deleteDirectory(public_path($path));
        }
         
        $user->delete();
        $post->delete();

        //delete rating user (post khac)
        $rating =  Rating::where('user_id', $request->id);
        $rating->delete();

    	return redirect()->back()->with('success', 'delete success');
    }

    public function search(Request $request){
    	$search = $request->search;
    	$user = User::where('name', 'like' , "%".$request->search."%")->Paginate(10);
    	return view('pages.userManager', ['user' => $user, 'search' => $search]);
    }
    public function findpost(Request $request){
    	$id = $request->id;
    	$data = \DB::table('posts')
			->join('photos', 'posts.id', '=', 'photos.post_id')
			->join('users','posts.user_id','=','users.id')
			->select('posts.id as post_id', 'posts.title', 'posts.describer', 'posts.created_at', 'posts.is_approved', 'photos.photo_path','users.name')
			->where('posts.user_id', '=', $id)
			->where('photos.flag', '=', '1')->paginate(5);
		//var_dump($data->count());
		//return;
		//	if($data->count() !==0)
		return view('pages/userpost', ['data' => $data]);
    }

    public function blockuser(Request $request){
    	$id = $request->id;
    	$user = User::where('id', $id)->first();
    	if($user->role==1){
    		return redirect()->back()->with('errro' , 'Ban khong the lock admin');
    	}
    	else{
    		if($user->status ==1){
    		$user->status =0;
	    	} 
	    	else{
	    		$user->status =1;
	    	}
    	}
    	$user->save();
    	return redirect()->back();
    }
}
