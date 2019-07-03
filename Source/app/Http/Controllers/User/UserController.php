<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;

class UserController extends Controller
{
    public function index()
    {
    	// $user['users']=User::all();
     //    return view('admin.user.index',$user);
           
           $user=User::all();
           return view('admin.user.index',['user'=>$user]);
    }
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
         $user=User::all();
           return view('admin.user.index',['user'=>$user]);
    }
    public function getedit ($id)
    {
    	$user=User::find($id);
        return view('admin.user.edit',['user'=>$user]);
    }
    public function postedit (Request $request,$id)
    {
        $user = User::find($id);

        $this->validate($request,
            [
                'name'=>'required|max:255',
                // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'status'=>'required'
                // 'phone'=>'required|max:11'
            ],
            [
                'name.max(255)'=>'ten co do dai ko qua 255',
                // 'email.unique'=>'email da ton tai'

                // 'phone.max(11)'=>'qua so'
            ]
        );
        $user->name = $request->get('name');

        // $user->email = $request->get('email');
        $user->birthday = $request->get('birthday');
        $user->address = $request->get('address');
        $user->phone = $request->get('phone');
        $user->role = $request->get('role');
        $user->status = $request->get('status');
        $user->avatar = $request->get('avatar');


        $user->save();

        return \Redirect::route('admin.user.edit', [$user->id])->with('message', 'User has been updated!');
        
    }

    public function xoa($id)
    {
        $user = User::find($id);
        
        $user->delete();
        $user=User::all();
        return view('admin.user.index',['user'=>$user]);
           
        // return redirect('admin.user.index')->with('thongbao','ban da xoa thanh cong');
    }
    public function block($id,Request $request)
    {
        $user = User::find($id);
        
        $user->status=0;
        $user->save();
        $user=User::all();
        return view('admin.user.index',['user'=>$user]);
           
        // return redirect('admin.user.index')->with('thongbao','ban da xoa thanh cong');
    }
}
