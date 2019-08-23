<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


require_once base_path('vendor\autoload.php');
class PhpSdkController extends Controller
{

  public function callback()
  {


    session_start();

    $fb = new \Facebook\Facebook([
      'app_id' => '2500657973298544',
      'app_secret' => 'fe55cfc3f3fbed74b5c1e02cda1a8869',
      //'default_graph_version' => 'v3.2',
    ]);

    $helper = $fb->getRedirectLoginHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    if (!isset($accessToken)) {
      if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
      } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
      }
      exit;
    }

    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $fbuser = $response->getGraphUser();
    $id = $fbuser['id'];
    $user = new \App\User;
    if (\App\Social::find($id) === NULL) {
      $social = new \App\Social;
      $social->id = $id;
      if (isset($fbuser['email']) === false) {
        $user->name = $fbuser['name'];
        $user->save();
      } else {
        $email = $fbuser['email'];
        $rows = \App\User::where('email', '=', $email)->first();
        if ($rows === NULL) {
          $user->name = $fbuser['name'];
          $user->email = $fbuser['email'];
          $user->save();
        } else {
          $user = \App\User::where('email', '=', $email)->first();
        }
      }
      $social->user_id = $user->id;
      $social->save();
    } else {
      $social = \App\Social::find($id);
      $user_id = $social->user_id;
      $user = \App\User::where('id', '=', $user_id)->first();
    }
    \Auth::login($user);
    return redirect('/');
  }
}
