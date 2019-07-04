<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  Auth, Redirect, Session, URL;
use App\User;
use App\Social;
class SocialAuthController extends Controller
{
	public function redirectToProvider()
	{
		session_start();
		$authorizeURL = 'https://accounts.google.com/o/oauth2/v2/auth';
		$_SESSION['state'] = bin2hex(random_bytes(16));
		$params = array(
			'client_id' => env('GOOGLE_ID'),
			'redirect_uri' => env('GOOGLE_REDIRECT'),
			'response_type' => 'code',
			'scope' => 'openid email profile',
			'state' => $_SESSION['state']
		);

  		// Redirect the user to Google's authorization page
		header('Location: '.$authorizeURL.'?'.http_build_query($params));
		die();
	}

	public function handleProviderCallback()

	{
		if(isset($_GET['code'])) {
			$tokenURL = 'https://www.googleapis.com/oauth2/v4/token';
			$ch = curl_init($tokenURL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
				'grant_type' => 'authorization_code',
				'client_id' => env('GOOGLE_ID'),
				'client_secret' => env('GOOGLE_SECRET'),
				'redirect_uri' => env('GOOGLE_REDIRECT'),
				'code' => $_GET['code'],
			]));
		$response = curl_exec($ch);//dang json
		$data = json_decode($response, true);//chuyen tu json sang array
		$token = explode('.', $data['id_token']);
		$userinfo = json_decode(base64_decode($token[1]), true);
		$_SESSION['user_id'] = $userinfo['sub'];
		$_SESSION['email'] = $userinfo['email'];
		$_SESSION['access_token'] = $data['access_token'];
		$_SESSION['id_token'] = $data['id_token'];
		$_SESSION['userinfo'] = $userinfo;
	}
	//gui access_token de lay thong tin ung dung
	if(!empty($_SESSION['user_id'])) {
		//cap quyen truy cap info user khi scope o tren khong co profile
		// $ch = curl_init('https://openidconnect.googleapis.com/v1/userinfo');
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, [
		// 	'Authorization: Bearer '.$_SESSION['access_token']
		// ]);
		// $user= json_decode(curl_exec($ch),true);

		// kiem tra mail da ton tai chua
		$existingUser = User::where('email', $userinfo['email'])->first();
		if($existingUser){
			// kiem tra social_id da ton tai chua
			$newname=User::where('name', $userinfo['name'])->first();
			$newavatar=User::where('avatar',$userinfo['picture'])->first();
			if(!$newname || !$newavatar){
				User::where('email', $userinfo['email'])->update(array(
					'name' 	  =>  $userinfo['name'],
					'avatar'	=>	$userinfo['avatar'],
				));
				$users = DB::table('users')->select('id')->get();

			}
			auth()->login($existingUser, true);
		} else {
            // tao 1 user moi vao db

			$newUser = new User;
			$newUser->name = $userinfo['name'];
			$newUser->email = $userinfo['email'];
			$newUser->avatar = $userinfo['picture'];
			$newUser->role = 3;
			$newUser->status = 1;
			$newUser->save();

			$userId = User::all()->last()->id;//truy van toi record cuoi
			$newSocial = new Social;
			$newSocial->id= $_SESSION['user_id'];
			$newSocial->user_id= $userId;
			$newSocial->save();


			auth()->login($newUser, true);
		}
		return redirect()->to('/');
	}
}

}
