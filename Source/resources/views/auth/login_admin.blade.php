@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h3>Sign In</h3></div>

        <div class="card-body">
          @if (session('error'))
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria_label="Close">
              <span aria_hidden= "true">&times;</span>
            </button>
            {{ session('error') }}
          </div>
          @endif
          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
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

            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Remember password</label>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Sign In
              </button>
              <a href="{{ url('/') }}" title=""  id="edit_button"class="btn btn-danger">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection