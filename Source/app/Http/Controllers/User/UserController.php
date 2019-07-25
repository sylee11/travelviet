<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use App\User;
use DB;
use App\Photo;
use app\Post;

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
            'status'=>'required',
            'avatar' => ' mimes:jpeg,jpg,png | max:1000'
        ],
        [
            'name.max(255)'=>'ten co do dai ko qua 255',
        ]
    );
    $user->name = $request->get('name');
    $user->birthday = $request->get('birthday');
    $user->address = $request->get('address');
    $user->phone = $request->get('phone');
    $user->role = $request->get('role');
    $user->status = $request->get('status');
        // $user->avatar = $request->get('avatar');

    if ($request->hasFile('avatar')) {
        $file=$request->file('avatar');
        $name=$file->getClientOriginalName();
        $avatar = str_random(4)."_".$name;
        while (file_exists("picture/".$avatar)) {
            $avatar = str_random(4)."_".$name;
        }
        $file->move("picture",$avatar);
        $user->avatar = $avatar;   

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
               'password.min(8)'=>'bạn nhập ít nhất 5 kí tự'  ,
               'passwordAgain.required'=>'bạn chưa nhập lại mật khẩu'     
           ]
       );
        $user->password=bcrypt($request->password);

    }


    $user->save();

    return \Redirect::route('admin.user.edit', [$user->id])->with('message', 'User has been updated!');

}

public function xoa($id)
{
    $user = User::find($id);
    // if($user->first()->role == 1){
    //     return \Redirect::route('admin.user.index')->back()->with('errro' , 'Ban khong the xoa admin');
    // }
   
        $photo =DB::table('photos')
        ->join('posts','photos.post_id','=','posts.id')
        ->join('users','posts.user_id','=','users.id')
        
        ->where([
            // ['photos.post_id', '=','posts.id'],
            ['user_id','=',$id]
        ])
        ->delete();
        // $rating1 =DB::table('ratings')
        //  ->join('posts','ratings.post_id','=','posts.id') 
        //  ->join('users','posts.user_id','=','users.id')
        //  ->where([
        //    ['posts.id','=','ratings.post_id']   
        //    ])
        //  ->delete();

         $rating =DB::table('ratings')  
         ->where([
            ['user_id','=',$id],
           ])
         ->delete();

        $post = DB::table('posts')
        ->where('user_id','=',$id)
        ->delete();
       
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
public function unblock($id,Request $request)
{
    $user = User::find($id);

    $user->status=1;
    $user->save();
    $user=User::all();
    return view('admin.user.index',['user'=>$user]);

        // return redirect('admin.user.index')->with('thongbao','ban da xoa thanh cong');
}
}
