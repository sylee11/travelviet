<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Place;
use App\Category;
use App\Photo;
use App\District;
use App\City;
use DB;
use Auth;
use File;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
	
    public function showformAddPost() {
    	$category = Category::all();
		$place = Place::all();
		$city = City::all();
		$district = District::all();
    	return view('pages.addpost',['category' => $category, 'place' => $place, 'city' =>$city, 'district' => $district]);
    }

    public function Add(Request $request, $id){
    	$request-> validate([
            'name' => 'required',
            'phone' => 'required',
            'title' => 'required',
            'descrice' => 'required',
            'address' => 'required',
        ]);


    	$place = Place::all();

    	// $check = $request->file();
    	// dd($check);
    	$post = new Post;
    	$post -> user_id = Auth::id();
    	$post -> phone = $request ->phone;

    	//check place exist
    	$findPlace = Place::where('name', '=', $request->name)->first();
    	if($findPlace){
    		 //dd($findPlace);
    	    $post ->place_id = $findPlace->id;

    	}
    	else{
    		$newPlace = new Place;
    		$newPlace->name = $request->name;
    		$newPlace->address = $request->address;
    		//save temp category_id vs district_id
    		//$newPlace->category_id = $request->category->id;
    		$newPlace->category_id = Category::where('name', $request->category)->first()->id;
    		$newPlace->districts_id = $request->districts_id;
    		$newPlace -> save();

    		$post ->place_id = $newPlace->id;
    	}

        $post ->title = $request ->title;
        $post ->is_approved = 0;
        $post ->describer = $request->descrice;
        $post ->save();

        $path="picture/admin/post/".$post->id;
	    File::makeDirectory($path);
	    
        if($request->has('filename')){
        	foreach ($request->file('filename') as $pho) {
        		$name=$pho->getClientOriginalName();
        		$photo = new Photo;
	        	$photo->post_id = $post->id;
	        	$pho->move($path, $name);  
	        	$photo->photo_path = "picture/admin/post/".$post->id."/".$name;
	        	$photo->flag = 0;
                $photo->save();
	        }
        }

        $photoflag = Photo::where('post_id', $post->id)->first();
        $photoflag->flag =1;
        $photoflag->save();
        $data = Post::join('photos', 'photos.post_id', '=', 'posts.id')
        ->where('posts.user_id', '=', $id)
        ->where('photos.flag', '=', '1')->paginate(5);
        //tuy chinh pagenation
        $data->withPath('../../mypost');

        return view('pages.mypost', ['data'=> $data]);
    }

    //xu li ajax tu dong them vung mien
     public function getCityList(Request $request)
	 {

	 	$findCity = City::where('name', '=', $request->cities_id)->first();
	 	$idC = $findCity -> id; 
	    $districts = DB::table("districts")
	    ->where("cities_id",$idC)
	    ->pluck("name","id");
	    return response()->json($districts);

	}


	public function showformEditPost($id , $idPost)
	{

		$post = Post::find($idPost);
		$category = Category::all();
		$place = Place::all();
		$city = City::all();
		//dd($post->describer);
		$district = District::all();
    	return view('pages.editpost',['category' => $category, 'place' => $place, 'city' =>$city, 'district' => $district, 'post' => $post]);
	}

	public function edit(Request $request, $id , $idpost){

		//edit post
		$posts = POST::find($idpost);
		// $posts ->place_id = $request->placeid;
        $posts ->phone = $request->phone;
        $posts ->is_approved = $request->approved;
        $posts ->title = $request ->title;
        $posts ->describer = $request->input('descrice');
        $posts -> save();

        //edit place
        $place = Place::where('name', $request->name)->first();
        $place ->address = $request->address;
      	$place->category_id = Category::where('name', $request->category)->first()->id;
      	$a = district::where('name', $request->districts_id)->get();
      	if($a->count() != 1){
        	$place->districts_id = $request->districts_id; 
     		
      	}
        $place->save();

        $path = 'picture/admin/post/'.$posts->id;
        if($request->has('filename')){
            foreach($request->file('filename') as $image)
            {   
                $name=$image->getClientOriginalName();

                //check photo exit
                $namet=$path."/".$name;                
                $t = DB::table('photos')
                ->where("post_id", "=", $id)->get();
                foreach ($t as $key => $value) {
                          if($value->photo_path ==  $namet  )
                              return "Photo exits";
                }  

                $image->move($path, $name);  
                $photo = new photo;
                $photo->photo_path = $path."/".$name;
                $photo->flag = 0;
                $photo->post_id=$posts->id;
                $photo ->save ();
            }
        }


        //delete photo
        $photoedit = $request->p1; // This will get all the request data.
        $edit = explode('/',$photoedit);
        foreach ($edit as $da => $value) {
            if(PHOTO::find($value))
            {
                $findphoto = PHOTO::find($value);
                $path =$findphoto->photo_path; 
                File::delete($path);
                $findphoto ->delete();
                
            }
        }
        $data = Post::join('photos', 'photos.post_id', '=', 'posts.id')
        ->where('posts.user_id', '=', $id)
        ->where('photos.flag', '=', '1')->paginate(5);
        //tuy chinh pagenation
        $data->withPath('../../../mypost');
        return view('pages.mypost', ['data'=> $data]);
        //dd($name); // This will dump and die
        //var_dump($data);
    }

    public function delete($id)
    {
        $posts = DB::table('posts')
            ->where('id' , '=' ,$id)->delete();
        $photo =DB::table('photos')
            ->where('post_id', '=' ,$id)->delete();
        $path = "/picture/admin/post/".$id; 
        File::deleteDirectory(public_path($path));
        $data = Post::join('photos', 'photos.post_id', '=', 'posts.id')
        ->where('posts.user_id', '=', $id)
        ->where('photos.flag', '=', '1')->paginate(5);
        //tuy chinh pagenation
        $data->withPath('../../mypost');
        return view('pages.mypost', ['data'=> $data]);
    }

}


