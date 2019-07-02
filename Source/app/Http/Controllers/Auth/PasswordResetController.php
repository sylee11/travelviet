<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\User;
use App\PasswordReset;
use RealRashid\SweetAlert\Facades\Aler;

class PasswordResetController extends Controller
{

	public function index(){

		return view('auth.passwords.email');
	}


	public function showResetForm(Request $request, $token = null)
    {
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
        	
        	 //return 'Send success';
            //return view('notifation.sendmailsuccess');
            return redirect()->route('sendmailsuccess');
        	//alert()->success('Thông báo','Send mail reset password success!');

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
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);



        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        // kiem tra token
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(1)->isPast()) {
             $passwordReset->delete();
             return response()->json([
                 'message' => 'This password reset token is invalid.'
             ], 404);
         }

        if (!$passwordReset )
            return response()->json([
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user)
            return response()->json([
                'message' => 'We cant find a user with that e-mail address.'
            ], 404);
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        //return response()->json($user);
        //return view('notifation.resetpassdone');
        return redirect()->route('resetpassdone');
    }
}