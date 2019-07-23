<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_Plus;
use App\User;
use App\Social;

class SocialAuthController extends Controller
{
    public function redirectToProvider()
    {
    	$client = new Google_Client();
    	$client->setRedirectUri(env('GOOGLE_REDIRECT'));
    	$client->addScope([
    		'https://www.googleapis.com/auth/plus.login',
    		'https://www.googleapis.com/auth/userinfo.email'
    	]);

    //Set param google API
    	$client->setClientId(env('GOOGLE_ID'));
    	$client->setClientSecret(env('GOOGLE_SECRET'));
    	$client->setAccessType('offline');
    	//Đây là URL bạn cần mở nếu chưa đăng nhập
    	$auth_url = $client->createAuthUrl();

    	if (isset($_SESSION['access_token']) && $_SESSION['access_token'])
    	{
        /*
         * Đã đăng nhập trước rồi do tồn tại access_token trong Session
         * Nên bạn không cần xác thực từ Google nữa mà chỉ việc lấy thông tin
         */
        $client->setAccessToken($_SESSION['access_token']);
        $plus = new Google_Service_Plus($client);
        if ($client->isAccessTokenExpired()) {
            //Truy cập bị hết hạn, cần xác thực lại
            //Chuyển hướng sang Google để lấy xác thực
        	$auth_url = $client->createAuthUrl();
        	header("Location: $auth_url");
        	die();
        }
		 //Lấy các thông tin của User
        $me = $plus->people->get('me');
        $email = @$me['emails'][0]['value'];
        $existingUser = User::where('email', $email)->first();
        auth()->login($existingUser, true);
        //Sau khi lấy được thông tin xử lý xong nhớ chuyển hướng sang trang khác.
        return redirect('/');
    }
    else
    {
        /**
         * Nếu tồn tại $_GET['code'] trên URL có nghĩa là Google vừa gửi Code truy cập tới cho bạn, bạn cần lấy thông
         * tin này để truy cập.
         */
        if (isset($_GET['code'])) {
        	$client->fetchAccessTokenWithAuthCode($_GET['code']);
            //Lấy mã Token và lưu lại tại SESSION
        	$_SESSION['access_token'] = $client->getAccessToken();
        	//getinfo($client);


        	$client->setAccessToken($_SESSION['access_token']);
        	$plus = new Google_Service_Plus($client);
        	if ($client->isAccessTokenExpired()) {
            //Truy cập bị hết hạn, cần xác thực lại
            //Chuyển hướng sang Google để lấy xác thực
        		$auth_url = $client->createAuthUrl();
        		header("Location: $auth_url");
        		die();
        	}


        //Lấy các thông tin của User
        	$me = $plus->people->get('me');
        $id    = @$me['id'];                    //ID
        $email = @$me['emails'][0]['value'];    //Địa chỉ email
        $name  = @$me['displayName'];           //Tên
        $image = @$me['image']['url'];          //Url của ảnh avatar

        $existingUser = User::where('email', $email)->first();
        if($existingUser){
			// kiem tra social_id da ton tai chua
        	auth()->login($existingUser, true);
        } else {
            // tao 1 user moi vao db

        	$newUser = new User;
        	$newUser->name= $name;
        	$newUser->email = $email;
        	$newUser->avatar = $image;
        	$newUser->save();

			$userId = User::all()->last()->id;//truy van toi record cuoi
			//dd($userId );
			$newSocial = new Social;
			$newSocial->id= $id ;
			$newSocial->user_id= $userId;
			$newSocial->save();


			auth()->login($newUser, true);
		}

        	//dd($_SESSION['access_token']);
            //Sau khi lấy được thông tin xử lý xong nhớ chuyển hướng sang trang khác.
		return redirect('/');
	}
	else
	{
            //Chuyển hướng sang Google để lấy xác thực
		$auth_url = $client->createAuthUrl();
		header("Location: $auth_url");
		die();
	}
}

}

}
