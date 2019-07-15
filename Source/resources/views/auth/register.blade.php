<head>
    <link rel="stylesheet" type="text/css" href="/css/custom/login.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="/css/bootstrap-social.css">
    <!--Custom styles-->
{{--     <link rel="stylesheet" href="/css/fontawesome.css">
 --}}</head>
<body class="text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <div>
                                    <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
                                    <a class="btn btn-block btn-social btn-google" href="{{route('login.social')}}" >
                                        <i class="fab fa-google"></i>

                                        Sign in with Google
                                    </a>
                                    <a class="btn btn-block btn-social btn-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        Sign in with Facebook
                                    </a>
                                    <p class="divider-text">
                                        <span class="bg-light">OR</span>
                                    </p>
                                </div>
                                
                                <!-- <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> -->

                                <div class="col-auto">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name"  placeholder=" Name" required autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                             <!--  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email ') }}</label> -->

                             <div class="col-auto">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder=" Email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="col-auto">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"  placeholder=" Password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                         <!--  <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> -->

                         <div class="col-auto">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"  placeholder="Password confirm">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
