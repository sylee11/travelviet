<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use DB;
use App\Photo;
use App\Post;
use App\Rating;
use File;
use Image;
use Config;

class UserController extends Controller
{
    public function index()
    {

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
            'email.required'=>'Bạn chưa nhập email',
            'email.email'=>'Bạn chưa nhập đúng định dạng',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'bạn chưa nhập mật khẩu',
            'password.min(8)'=>'Bạn nhập ít nhất 8 kí tự',


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
    return redirect()->back()->with('success',Config::get('constant.user.addUser'));
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
            'avatar' => ' mimes:jpeg,jpg,png | max:1000'
        ]
    );
    $user->name = $request->get('name');
    $user->birthday = $request->get('birthday');
    $user->address = $request->get('address');
    $user->phone = $request->get('phone');
    if($user->role!=1){
        $user->role = $request->get('role');
    }    
    else
        $user->role=1;
    if($user->role!=1){
        $user->status = $request->get('status');
    }  
    else
        $user->status=1;

    if ($request->hasFile('avatar')) {

     $avatar = $request->avatar;
     $avatarName = "/picture/avatar/" . $request->avatar->getClientOriginalName();
     Image::make($avatar)->save(public_path($avatarName));
     $user->avatar = $avatarName;
     $user->save();

 }
 else
 {
    $user->avatar = $user->avatar; 
}

if(isset($request->changePassword ))
{
    $this->validate($request,
        [
            
            'password' => ['required', 'string', 'min:8'],
            'passwordAgain'=>'required|same:password'

        ],
        [   
           'password.required'=>'bạn chưa nhập pass',
           'password.min(8)'=>'bạn nhập ít nhất 8 kí tự'  ,
           'passwordAgain.required'=>'bạn chưa nhập lại mật khẩu'     
       ]
   );
    $user->password=bcrypt($request->password);

}


$user->save();

return \Redirect::route('admin.user.edit', [$user->id])->with('message', Config::get('constant.user.editUser'));

}

public function xoa($id)
{
    $user = User::find($id);
    $check = $user->role;
    if($check == 1){
        return redirect()->back()->with('error' , Config::get('constant.user.deleteAdminUser'));
    }
    else{
        $post1 = Post::where('user_id', $id);
        $postid = Post::where('user_id', $id)->get();
        foreach ($postid as $p) {  
            $photo = Photo::where('post_id', $p->id);      
            $rating2 = Rating::where('post_id', $p->id);  
            $path = "/picture/admin/post/".$p->id;         
            $rating2->delete();     
            $photo->delete();
            File::deleteDirectory(public_path($path));    
        }
        $rating =DB::table('ratings')  
        ->where([
            ['user_id','=',$id],
        ])
        ->delete();
        $social =DB::table('socials')  
        ->where([
            ['user_id','=',$id],
        ])
        ->delete();
        $post = DB::table('posts')
        ->where('user_id','=',$id)
        ->delete();

        $user->delete();

        $user=User::all();
        return redirect()->back()->with('success',Config::get('constant.user.deleteUser'));
  }

}
public function block($id,Request $request)
{
    $user = User::find($id);
    $check = $user->role;
   // dd($check);
    if($check == 1){

        return redirect()->back()->with('error' , Config::get('constant.user.blockAdminUser'));
    }
    else{
       $user->status=0;
       $user->save();
       $user=User::all();
       return redirect()->back()->with('success',Config::get('constant.user.blockUser')); 
   }

}
public function unblock($id,Request $request)
{
    $user = User::find($id);

    $user->status=1;
    $user->save();
    $user=User::all();
    return redirect()->back()->with('success',Config::get('constant.user.unblockUser'));
}
}
