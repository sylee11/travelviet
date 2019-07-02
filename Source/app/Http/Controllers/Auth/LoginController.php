<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
/*    public function showLoginForm(){
        return view('auth.login2');
    }


    public function postLogin(Request $request) {
    	
    	
        $email =\Request::get('loginEmail');  
        $password = \Request::get('loginPassword');
        
            
       if( \Auth::attempt(['email' => $email, 'password' =>$password])) {
         
            return view('pages/home');
          
        } else {
            $errors = new \Illuminate\Support\MessageBag();

            // add your error messages:
            $errors->add('errorlogin', 'Email hoặc mật khẩu không đúng');
        
            return view('auth/login2')->withErrors($errors);
          //  return view('auth/login2');
        }
    }
    public function logout(Request $request) {
        \Auth::logout();
        return view('pages/home');
        
      }
    */
}
