<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Post;
use App\User;
use Carbon\Carbon;
use App\Photo;
use File;
use App\Rating;
use App\Place;
use Illuminate\Support\Facades\Validator;


class PostController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts =User::find(1)->post;
        // $user = $posts->user;
        //dd($posts);
        //$user = User::post();
        

        // $posts = DB::table('posts')
        //     ->join('users', 'users.id', '=', 'posts.user_id')
        //     ->select('posts.*', 'users.name')
        //     ->get();
        //$posts = POST::all() ;
        //$user = USER::find(10)->get();
        //dd($userss);
        // $user = User::find(1);
        // $posts->user()->get();

        //$posts = POST::find(33)->get();

        //eloquent 
        $postss = POST::all();
        $user = USER::all();
        $place = PLACE::all();
        return view('admin.post.index', ['posts'=>$postss , 'user'=>$user ,'place'=>$place]);
        //dd($posts);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request-> validate([
            'user_id' => 'reiquired',
            'number' => 'required|max:10',
            'title' => 'required',
            'describer' => 'required',
        ]);

        // import posts
        $posts = new POST;
        //check user dóe'n exist
        if(USER::find($request->userid)){
            $posts -> user_id = $request ->userid;
        }
        else{
            return "userid not exist";
        }

        $posts -> phone = $request ->number;
        $posts -> place_id = $request ->placeid;
        $posts -> title = $request ->title;
        if($request ->describer){
        $posts -> describer = $request ->input('describer');
        }
        else return "none describer";
        // $t = $request -> checkbox;
        // dd($t);
        if($request->checkbox){
            $posts -> is_approved = $request -> checkbox;
        }
        else{
        $posts -> is_approved =0;
        }
        $posts -> save();

        //find last id
       // $posts = POST::latest()->first();
        //$posts = $posts->id
        //make folder chua photo
        $path = 'picture/admin/post/'.$posts->id;
        File::makeDirectory($path);

        //insert 1 photo

        // $file = $request->filesTest;
        // $file->move('picture', $file->getClientOriginalName());
        //$photo = new PHOTO;
        // $photo->photo_path = "picture/".$file->getClientOriginalName();
        // $photo->flag = 0;
        // $photo->posts_id=$posts->id;
        // $photo ->save ();



        //insert multi photo
        if($request->has('filename')){
            foreach($request->file('filename') as $image)
            {   

                $name=$image->getClientOriginalName();

                //check photo exit
                $namet=$path."/".$name;                
                $t = DB::table('photos')
                ->where("post_id", "=", $posts->id)->get();
                foreach ($t as $key => $value) {
                        if($value->photo_path ==  $namet  ){
                            $p = POST::find($posts->id)->delete();
                            return "anh trung nhau";
                        }
                }  

                $image->move($path, $name);  
                $photo = new photo;
                $photo->photo_path = $path."/".$name;
                $photo->flag = 0;
                $photo->post_id=$posts->id;
                $photo ->save ();
            }
            $photoflag = Photo::where('post_id', $posts->id)->first();
            $photoflag->flag =1;
            $photoflag->save();
            return back()->with('success', 'Your images has been successfully');
        }
        return "You are not choose picture";
 
        //return redirect (route('admin.post.index'));



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showformedit($id)
    {
        $posts = POST::find($id);
         $user = USER::all();
        $place = PLACE::all();
        return view('admin.post.edit', ['post'=>$posts, 'user'=>$user ,'place'=>$place] );
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        // xu li edit info
        $posts = POST::find($id);
        if(USER::find($request->userid)){
            $posts ->user_id = $request ->userid;
        }
        else{
            return "userid not exist";
        }
        // if(PLACE::find($request->placeid)){
        //     $posts ->place_id = $request ->placeid;
        // }
        // else{
        //     return "placeid not exist";
        // }
        $posts ->place_id = $request->placeid;
        $posts ->phone = $request->phone;
        $posts ->is_approved = $request->approved;
        $posts ->title = $request ->title;
        $posts ->describer = $request->input('descricer');

        $posts -> save();



        // xu li them anh moi
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
        //dd($posts);


        //delete photo
        $photoedit = $request->p1; // This will get all the request data.
        //$data = json_decode($request->getContent());
        // return $request->xxx; 
        //exit();
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
            return redirect() ->back()->with('erro', " Please chose one image and save again");
        }

        $photoflag = Photo::where('post_id', $posts->id)->first();
        $photoflag->flag =1;
        $photoflag->save();

        
        return redirect (route('admin.post.detail', $posts->id))->with('success', "Changed done");
        //return back()->with('success', 'Your images has been successfully');
        //dd($name); // This will dump and die
        //var_dump($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //query bulder
        $posts = DB::table('posts')
            ->where('id' , '=' ,$id)->delete();
        $photo =DB::table('photos')
            ->where('post_id', '=' ,$id)->delete();
        $path = "/picture/admin/post/".$id; 
        File::deleteDirectory(public_path($path));

        $rating =Rating::where('post_id', $id)->delete();
        $postss = POST::all();
        return redirect (route('admin.post.index'))->with('success', 'delete had!');
        // $posts= POST::all();



    }

    public function approved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id)
            ->update(['is_approved' => 1]);
        $posts= POST::all();
        return redirect (route('admin.post.index'));


    }   

    public function unapproved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id )
            ->update(['is_approved' => 0]);
        // $posts= POST::all();

        // return view('admin.post.index', ['posts'=>$posts]);
        return redirect (route('admin.post.index'));

    }   

    //show detail posts
    public function detail($id)
    {
        $posts = POST::find($id);
        // chu y dặt tên biến
        return view('admin.post.detail', ['post'=>$posts] );
        //$a = $posts->photos;
        //dd($posts->photos[0]->id);
  
    }


    public function deletephoto($id)
    {
        $photos = PHOTO::find($id);
        $photos ->delete();
        $path =$photos->photo_path; 
        File::delete($path);
        //return( "avc");
        return back();
        //dd($path);
    }


}
