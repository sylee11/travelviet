<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Post;
use App\Rating;
use App\Photo;
use App\Social;
use File;
use Config;
class UserController extends Controller
{
    //show all user in system
    protected function show(){
    	$search = "";
    	$user = DB::table('users')
    	->select('users.*')
    	->Paginate(config::get('constant.pagenation'));
    	return view('pages.userManager', ['user' => $user,'search' => $search]);
    }

    //delete one user
    public function delete(Request $request){
    	$user = User::where('id',$request->id);
    	if($user->first()->role == 1){
    		return redirect()->back()->with(config::get('constant.error'), config::get('constant.message_delete_fail'));
    	}
        //Transaction database
        $av = $request->id;
        DB::transaction(function(){
        	$post = Post::where('user_id', 'nam');
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
            $social=Social::where('user_id',$request->id);
            $social->delete(); 
            $user->delete();
            $post->delete();

            //delete rating user (post khac)
            $rating =  Rating::where('user_id', $request->id);
            $rating->delete();
        });
    	return redirect()->back()->with(config::get('constant.success'), config::get('constant.message_delete_success'));
    }

    //Search user
    public function search(Request $request){
    	$search = $request->search;
    	$user = User::where('name', 'like' , "%".$request->search."%")->paginate(Config::get('constant.pagenation'));
        $user->appends(['search'=>$search]);
    	return view('pages.userManager', ['user' => $user, 'search' => $search]);
    }

    //Find all post of one user
    public function findpost(Request $request){
    	$id = $request->id;
    	$data = \DB::table('posts')
        ->join('photos', 'posts.id', '=', 'photos.post_id')
        ->join('users', 'posts.user_id', '=', 'users.id')
        ->select('posts.id as post_id', 'posts.title','posts.slug' ,'posts.describer', 'posts.created_at', 'posts.is_approved', 'photos.photo_path', 'users.name')
        ->where([
            ['posts.user_id', '=', $id],
            ['posts.is_approved', '=', '1'],
            ['photos.flag', '=', '1']
        ])
        ->orderBy('posts.id', 'desc')
        ->paginate(Config::get('constant.pagination1'));
        return view('pages/userpost', ['data' => $data]);
    }

    //Block one user(not is admin)
    public function blockuser(Request $request){
    	$id = $request->id;
    	$user = User::where('id', $id)->first();
    	if($user->role==1){
    		return redirect()->back()->with(config::get('constant.error') , 'Ban khong the lock admin');
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
