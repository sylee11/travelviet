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
        return view('admin.post.index', ['posts'=>$postss ]);
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
        // $request-> validate([
        //     'user_id' => 'reiquired|numeric',
        //     'phone' => 'required|numberic|max:10',
        //     'title' => 'required',
        //     'describer' => 'required',
        //     'place_id' => 'required|number',
        // ]);

        // $validator = Validator::make($request->all(), [
        //     'user_id' => 'reiquired|numeric',
        //     'phone' => 'required|numberic|max:10',
        //     'title' => 'required',
        //     'describer' => 'required',
        //     'place_id' => 'required|number',
        // ]);

        // if ($validator->fails()) {
        //     return redirect('/admin/post/add')
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }

        // $posts = DB::table('posts')
        //     ->insert([
        //         'user_id' => $request ->input('userid'),
        //         'phone' => $request ->input('phone'),
        //         'title' => $request ->input('title'),
        //         'describer' => $request ->input('descrice'),
        //         'place_id' => $request ->input('placeid'),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),

        //     ]);

        // dd($post);
        // $posts= DB::table('posts')
        //     ->join('users', 'users.id', '=', 'posts.user_id')
        //     ->select('posts.*', 'users.name')
        //     ->get();

        // $posts = POST::all;
        // return view('admin.post.index', ['posts'=>$posts]);
        // var_dump($request->input('userid'));


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
        if($request->checkbox){
            $posts -> is_approved = $request -> checkbox;
        }
        $posts -> is_approved =0;
        $posts -> save();

        //find last id
        $temp = POST::latest()->first();
        //make folder chua photo
        $path = 'picture/admin/post/'.$temp->id;
        File::makeDirectory($path);

        //insert 1 photo

        // $file = $request->filesTest;
        // $file->move('picture', $file->getClientOriginalName());
        //$photo = new PHOTO;
        // $photo->photo_path = "picture/".$file->getClientOriginalName();
        // $photo->flag = 0;
        // $photo->posts_id=$temp->id;
        // $photo ->save ();



        //insert multi photo
        if($request->has('filename')){
            foreach($request->file('filename') as $image)
            {   

                $name=$image->getClientOriginalName();
                $image->move($path, $name);  
                $photo = new photo;
                $photo->photo_path = $path."/".$name;
                $photo->flag = 0;
                $photo->posts_id=$temp->id;
                $photo ->save ();
            }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            ->where('posts_id', '=' ,$id)->delete();
        // $posts= POST::all();

        // return view('admin.post.index', ['posts'=>$posts]);
        return redirect (route('admin.post.index'));

    }

    public function approved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id)
            ->update(['is_approved' => 1]);
        $posts= POST::all();
        return view('admin.post.index', ['posts'=>$posts]);

    }   

    public function unapproved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id)
            ->update(['is_approved' => 0]);
        // $posts= POST::all();

        // return view('admin.post.index', ['posts'=>$posts]);
        return redirect (route('admin.post.index'));

    }   
}
