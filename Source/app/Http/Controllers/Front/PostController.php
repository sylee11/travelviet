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
use App\Rating;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CreatePost;
use Illuminate\Support\Str;
use App\Events\CreatePostHandler;
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

    public function Add(Request $request){
    	$request-> validate([
            'name' => 'required',
            'phone' => 'required|min:10 ',
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

        //check một lần nữa tỉnh huyênj
        if(District::where('name' , $request->districts_id)->first() == null){
            return redirect()->back()->with('erro', 'kiểm tra lại dư liệu nhập')->withInput($request->input());;
        }
        else{
            if(City::where('id',District::where('name' , $request->districts_id)->first()->cities_id) == $request->districts_id){
                    $findIdPDistrict = District::where('name' , $request->districts_id)->first()->id;
            }
            else{
                return redirect()->back()->with('erro', 'kiểm tra lại dư liệu nhập')->withInput($request->input());;
            }
        }
    	//check place exist
    	$findPlace = Place::where([
            ['name', '=', $request->name],
            ['districts_id', '=', $findIdPDistrict]
            ])->first();
    	if($findPlace){
    		 //dd($findPlace);
    	    $post ->place_id = $findPlace->id;

    	}
    	else{
    		$newPlace = new Place;
    		$newPlace->name = $request->name;
    		$newPlace->address = $request->address;
            $newPlace->lat = $request->lat;
            $newPlace->longt = $request->lng;
    		//save temp category_id vs district_id
    		//$newPlace->category_id = $request->category->id;
    		$newPlace->category_id = Category::where('name', $request->category)->first()->id;
            
            $newPlace->districts_id = $findIdPDistrict;

    	}

        $post ->title = $request ->title;
        $post ->is_approved = 0;
        $post ->describer = $request->descrice;
        // $post ->save();
        //$post ->slug = Str::slug($request->title, '-');

        
	    
        //check image
        if($request->has('filename')){
        	foreach ($request->file('filename') as $pho) {
        		$name=$pho->getClientOriginalName();
                $thumbnailImage = Image::make($pho);
                if($thumbnailImage->width() < 1000 || $thumbnailImage->height()<600)
                {
                    return redirect()->back()->with('erro','Vui lòng chọn hình có kích thước tối thiểu 1000 * 600 .( hình quá nhỏ so với yêu cầu)')->withInput($request->input());
                }
                if($thumbnailImage->width() > 2500 && $thumbnailImage->height()>1300)
                {
                    return redirect()->back()->with('erro','Vui lòng chọn hình có kích thước tối thiểu 1000 * 600 .( hình quá lớn so với yêu cầu)')->withInput($request->input());
                }
	        }
        }

        //save new place
        if($findPlace == null){
            $newPlace -> save();
            $post ->place_id = $newPlace->id;

        }
        //save post
        $post ->save();
        event(new CreatePostHandler($post));
        $toUsers = User::where('role','1')->get();
        \Notification::send($toUsers, new CreatePost($post));
        //create folder
        $path="picture/admin/post/".$post->id;
        if (!file_exists($path)) {
            File::makeDirectory($path);
        }
        //save image
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

        return redirect()->route('mypost')->with('success', " Thêm bài đăng thành công");
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


	public function showformEditPost($idPost)
	{

        $id = Auth::id();
        //check 
        if(Post::where('slug', $idPost)->first() == null){
            return view('includes.erro404');
        }
        if( Post::where('slug', $idPost)->first()->user_id != $id){
            return view('includes.erro404');            
        }
		$post = Post::where('slug',$idPost)->first();
		$category = Category::all();
		$place = Place::all();
		$city = City::all();
		//dd($post->describer);
		$district = District::all();
    	return view('pages.editpost',['category' => $category, 'place' => $place, 'city' =>$city, 'district' => $district, 'post' => $post]);
	}

	public function edit(Request $request, $idpost){
		//edit post
        //check idpost input co khớp k
        if(POST::find($idpost) == null || POST::find($idpost)->user_id != Auth::id()){
            return redirect()->back()->with("erro", "Sửa bài viết thất bại!");
        }
		$posts = POST::find($idpost);
		// $posts ->place_id = $request->placeid;
        $posts ->phone = $request->phone;
        if($request->approved != null){
            $posts ->is_approved = $request->approved;
        }
        $posts ->title = $request ->title;
        $posts ->describer= $request->input('descrice');

        //edit place
        $place = Place::where([
            ['name', $request->name],
            ['districts_id', District::where('name',$request->districts_id)->first()->id]
            ])->first();
        $place ->address = $request->address;
      	$place->category_id = Category::where('name', $request->category)->first()->id;
        $place->districts_id = District::where('name', $request->districts_id)->first()->id; 
        //edit photos
        $path = 'picture/admin/post/'.$posts->id;
        if($request->has('filename')){
            foreach($request->file('filename') as $image)
            {   
                $name=$image->getClientOriginalName();

                //check photo exit
                $namet=$path."/".$name;                
                $t = DB::table('photos')
                ->where("post_id", "=", $idpost)->get();
                foreach ($t as $key => $value) {
                        if($value->photo_path ==  $namet  )
                        return redirect()->back()->with('erro','Photo does exitst');

                }  
                $thumbnailImage = Image::make($image);
                if($thumbnailImage->width() < 800 || $thumbnailImage->height()<500)
                {
                    return redirect()->back()->with('erro','Vui lòng chọn hình có kích thước tối thiểu 800 * 500 .( hình quá nhỏ so với yêu cầu)');
                }
                if($thumbnailImage->width() > 2500 && $thumbnailImage->height()>1300)
                {
                    return redirect()->back()->with('erro','Vui lòng chọn hình có kích thước tối da 2500 * 1300 .( hình quá lớn so với yêu cầu)');
                }
                $image->move($path, $name);  
                $photo = new photo;
                $photo->photo_path = $path."/".$name;
                $photo->flag = 0;
                $photo->post_id=$posts->id;
                $photo ->save ();
            }
        }

        $posts -> save();
        $place->save();
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

        $photocheck = Photo::where('post_id', $posts->id);
        if($photocheck->count() == 0){
            return "NOT Image chosed";
        }
        $photoflag = Photo::where('post_id', $posts->id)->first();
        $photoflag->flag =1;
        $photoflag->save();

        return redirect()->route('mypost')->with('success', ' Edit thanh công');

    }

    public function delete($id)
    {
        if(POST::where('id', $id)->first() == null){
            return redirect()->back()->with("errro","không thể xóa !!");            
        }
        $check = POST::where('id', $id)->first()->user_id;
        if($check != Auth::id()) {
            return redirect()->back()->with("errro","không thể xóa !!");
        }
        else

        {
            $posts = DB::table('posts')
                ->where('id' , '=' ,$id)->delete();
            $photo =DB::table('photos')
                ->where('post_id', '=' ,$id)->delete();
            $path = "/picture/admin/post/".$id;
            $rating = Rating::where('post_id', $id)->delete(); 
            File::deleteDirectory(public_path($path));
            return redirect()->route('mypost')->with('success', ' Xóa thanh công');
        }
    }

    public function autocomplete(Request $request)
    {
        $search = $request->get('term');
        $result = Place::where('name', 'LIKE',$search. '%')->get();
        return response()->json($result);
    }

    public function autocompleteTinh(Request $request)
    {
        $search = $request->get('term');
        $result = City::where('name', 'LIKE',$search. '%')->get();
        return response()->json($result);
    }

    public function autocompleteHuyen(Request $request)
    {
        $search = $request->get('term');
        $findID = City::where('name', $request->get('city'))->first()->id;
        if($request->get('term') == ""){
            $result = District::where([
                ['cities_id',$findID]
            ])->get();
            return response()->json($result);
        }
        $result = District::where([
            ['cities_id',$findID],
            ['name', 'LIKE', '%'.$search.'%']
        ])->get();
        return response()->json($result);
    }
    public function autocompleteAddress(Request $request){
        // $search = Place::where('name', $request->term)->first()
        $result = Place::join('districts', 'places.districts_id', '=', 'districts.id')
                ->join('cities','districts.cities_id','=','cities.id')
                ->select('districts.name as districtname', 'cities.name as cityname' ,'places.address as address')
                ->where('places.name','=',$request->term)
                ->first();
        return response()->json($result);
    }

}


