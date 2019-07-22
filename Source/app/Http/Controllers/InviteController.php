<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invite;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteCreated;
use App\Notifications\InviteRequest;

class InviteController extends Controller
{
	public function show(){
    return view('pages.invite');
  }
  public function process(Request $request){
    do {
          //generate a random string using Laravel's str_random helper
     $token = str_random();
      } //check if the token already exists and if it does, try again
      while (Invite::where('token', $token)->first());

      //create a new invite record
      $invite= new Invite();
      $invite->email=$request->get('email');
      $invite->token= md5(uniqid(rand(), true));
      //dd($invite);

      $invite->save();
      // send the email
      Mail::to($request->get('email'))->send(new InviteCreated($invite));
      // redirect back where we came from
      return redirect()->back()->with('success','Bạn đã gửi mail thành công!');
    }
  }
