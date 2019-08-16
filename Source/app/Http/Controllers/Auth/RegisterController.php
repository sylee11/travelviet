<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function showFormRegister(){
        return view('auth.register');
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
        echo bcrypt("123456").'->'.bcrypt("123456");
        dd(bcrypt("123456"));
        $user->role=$request->role;
        $user->status=1;
        $user->save();
        // $save =User::insert($user);
        // if($save)
             // return view('admin.user.index');
        // else 
        return redirect('/')->with('thongbao','Đăng kí thành công');


    }
}
