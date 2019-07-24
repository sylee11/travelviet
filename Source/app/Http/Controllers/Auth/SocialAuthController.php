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
        session_start();
        $google_client_id       = '810089435204-1qut7f9hs76quc0h4oesltaagc9q67d0.apps.googleusercontent.com';
        $google_client_secret   = '7q8I1Tto2_roQKOphXXHAhSu';
        $google_redirect_url    = 'http://127.0.0.1:8000/auth/google/callback';

        $client = new Google_Client();
        $client->setRedirectUri($google_redirect_url);
        $client->addScope([
            'https://www.googleapis.com/auth/plus.login',
            'https://www.googleapis.com/auth/userinfo.email'
        ]);

    //Set param google API
        $client->setClientId( $google_client_id);
        $client->setClientSecret($google_client_secret);
        $client->setAccessType('offline');
        //Đây là URL bạn cần mở nếu chưa đăng nhập
        $auth_url = $client->createAuthUrl();

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
            //Sau khi lấy được thông tin xử lý xong chuyển hướng sang trang khác.
        return redirect('/');
    }
    else
    {
            //Chuyển hướng sang Google để lấy xác thực
        $auth_url = $client->createAuthUrl();
        header("Location: $auth_url");
        die();
    }
//}

}

}