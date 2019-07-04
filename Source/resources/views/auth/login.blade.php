<link rel="stylesheet" type="text/css" href="css/custom/login.css">
<link rel="stylesheet" href="css/bootstrap.min.css">


<link rel="stylesheet" href="css/bootstrap-social.css">


<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">



<?php
require base_path('vendor\autoload.php');
session_start();
$fb = new Facebook\Facebook([
    'app_id' => '2500657973298544', // Replace {app-id} with your app id
    'app_secret' => 'fe55cfc3f3fbed74b5c1e02cda1a8869',
   // 'default_graph_version' => 'v3.2',
    ]);
  
  $helper = $fb->getRedirectLoginHelper();
  
  $permissions = ['email']; // Optional permissions
  #$loginUrl = $helper->getLoginUrl('https://test.test/fb-callback.php', $permissions);
  $loginUrl = $helper->getLoginUrl('https://travel.test/fb-callback', $permissions);
 // echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
  //echo '<a href="'.$loginUrl.'">fb</a>';
  //echo "<a href = {$loginUrl}>fbook</a>";
  //echo $loginUrl;
?>
<div class="container">



    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

         
        

                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                <a href="{{route('login.social')}}" class="btn btn-block btn-social btn-google">
        <i class="fab fa-google"></i>

            Sign in with Google
        </a>
        <a href="{{$loginUrl}}" class="btn btn-block btn-social btn-facebook">
        <i class="fab fa-facebook-f"></i>
            Sign in with Facebook
        </a>
        <p class="divider-text">
            <span class="bg-light">OR</span>
        </p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


