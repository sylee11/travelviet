<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Post;
use App\User;
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
        

        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name')
            ->get();

        return view('admin.post.index', ['posts'=>$posts]);
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
         $posts= DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name')
            ->get();
        return view('admin.post.index', ['posts'=>$posts]);

    }

    public function approved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id)
            ->update(['is_approved' => 1]);
        $posts= DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name')
            ->get();
        return view('admin.post.index', ['posts'=>$posts]);

    }   

    public function unapproved($id)
    {
        //eloquent
        $posts = DB::table('posts')
            ->where('id', '=' , $id)
            ->update(['is_approved' => 0]);
        $posts= DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name')
            ->get();
        return view('admin.post.index', ['posts'=>$posts]);

    }   
}
