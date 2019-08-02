<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;

class PasswordResetController extends Controller
{

	public function index(){

		return view('auth.passwords.email');
	}


	public function showResetForm(Request $request, $token = null)
    {   
        if(count(PasswordReset::where('token', $token)->get()) == 0){
            return view('includes.erro404');
        }
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }


    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user)
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => md5(uniqid(rand(), true))


             ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );

            return redirect()->route('sendmailsuccess');

    }
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
   
    public function reset(Request $request)
    {
    	

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string'
        ]);


        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        // kiem tra token
        if (!$passwordReset ){
             return redirect()->back()->with("erro","Nhap sai Email");
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(5)->isPast()) {
             $passwordReset->delete();
             return view('includes.erro404');
         }

        
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
             return redirect()->back()->with("erro","Nhap sai Email");
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        //return response()->json($user);
        //return view('notifation.resetpassdone');
        return redirect()->route('resetpassdone');
    }
}