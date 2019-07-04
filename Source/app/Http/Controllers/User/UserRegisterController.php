<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;

class UserRegisterController extends Controller
{
    // public function index()
    // {
    // 	$user['users']=User::all();
    //     return view('admin.user.index',$user);
           
    //        // $user=User::all();
    //        // return view('admin.user.index',['user'=>$user]);
    // }
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'name'=>'required|max:255',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8']

            ],
            [
                'name.required'=>'bạn chưa nhập tên người dùng',
                'name.max(255)'=>'ten co do dai ko qua 255',
                'email.required'=>'bạn chưa nhập email',
                'email.email'=>'bạn chưa nhập đúng định dạng',
                 'email.unique'=>'email da ton tai',
                 'password.required'=>'bạn chưa nhập mk',
                 'password.min(8)'=>'bạn nhập ít nhất 5 kí tự',
                 
               
            ]
        );
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= bcrypt($request->password);
        $user->role=$request->role;
        $user->status=1;
        $user->save();
        // $save =User::insert($user);
        // if($save)
             // return view('admin.user.index');
        // else 
             return \Redirect::route('pages.home')->with('thongbao','Đăng kí thành công');

    	

    	

    }
    
}
