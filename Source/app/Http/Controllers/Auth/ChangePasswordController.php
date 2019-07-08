<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class ChangePasswordController extends Controller
{
	public function show(){
		return view('pages.changePassword');
	}
	public function update(Request $request){
		$validatedData = $request->validate([
			'current_password' => 'required',
			'new_password' => 'required|min:6',
		]);
		if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
			return redirect()->back()->with("error","Your current password does not matches with the password you provided");
		}else if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
			return redirect()->back()->with("error","New Password cannot be same as your current password");
		}else if(strcmp($request->get('password_confirmation'), $request->get('new_password')) != 0){
			return redirect()->back()->with("error","Password confirm not same");
		}
		else{
			$user = Auth::user();
			$user->password = Hash::make($request->get('new_password'));
			$user->save();
			return redirect()->back()->with("success","Password changed successfully !");
		}
	}
}
