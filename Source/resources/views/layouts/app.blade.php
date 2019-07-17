<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Travel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap&subset=latin-ext,vietnamese" rel="stylesheet">

  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


  <link rel="stylesheet" href=" {{ asset('fonts/fontawesome/css/font-awesome.min.css') }}">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

{{--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
--}}
<!-- Rating -->
<link href="{{ asset('css/bootstrap-rating.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('js/bootstrap-rating.js') }}"></script>
@stack('css')

{{-- multi up image --}}
<script src="{{asset('js/dropzone.js')}}"></script>


<meta name="csrf-token" content="{{ csrf_token() }}">

@yield('header') 
</head>
<body>
    <!-- <script type="text/javascript">
        alert();
      </script> -->
      <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-inverse shadow-sm  fixed-top" style="font-family: 'Roboto', sans-serif; background-size: cover;   background-color: rgba(0,0,0,0.6);">
          <div class="container" style="color: white; margin: 0px; width: 100%">
            <a class="navbar-brand" href="{{ route('home.page') }} " style="color: white; font-size: 20px;" >
              Travel Việt
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav mr-auto" >
                <li > <a href="" class="nav-link " style="color: white; "> About Us </li></a>
                <li > <a href="" class="nav-link" style="color: white; "> Địa điểm </li></a>
                <li >  <a href="" class="nav-link" style="color: white; ">ABC </li></a>
                <li ><a href=""  class="nav-link" style="color: white; "> Liên hệ </li></a>
              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav ml-auto " style="display: flex; justify-content:flex-end; margin-left: 2000px">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                  <a   class="nav-link" data-toggle="modal" data-target="#myModal"  href="{{ route('login') }}" style="color: white; ">{{ __('Đăng nhập') }}</a>

                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link" data-toggle="modal" data-target="#myModal2" href="{{ route('register') }}" style="color: white; ">{{ __('Đăng kí') }} </a>
                </li>
                @endif
                @else

                <li class="nav-item dropdown" style="">
                 <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  style="color: white;font-size: 13px;" v-pre>

                  <img @if(!empty(Auth::user()->avatar)) src="/{{Auth::user()->avatar}}" @else src="/picture/images.png" @endif alt="Avatar" width="40px" style="border-radius: 50%;margin-right: 10px;">
                  @if (!empty(Auth::user()->name))
                  {{Auth::user()->name}}
                  @else
                  Noname
                  @endif
                  @if (empty(Auth::user()->name)|| empty(Auth::user()->avatar) || empty(Auth::user()->email))
                  <span class="badge badge-danger">1+</span>
                  @endif
                  <span class="caret"> </span>

                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                 <a class="dropdown-item" href="{{route('profile')}}" >Profile 
                  <span class="badge badge-danger" style="">
                    @if (empty(Auth::user()->name)|| empty(Auth::user()->avatar) || empty(Auth::user()->email))
                    1+
                    @endif
                  </span>
                </a>
                <a class="dropdown-item" href="{{route('show_changePass')}}">Change Password</a>
                @if (Auth::user()->role == 1)
                <a class="dropdown-item" href="{{route('admin.index')}}">Administrators</a>
                <a class="dropdown-item" href="{{route('mypost')}}">My posts</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#upgradeModal">Interactive history</a>
                <a class="dropdown-item" href="{{route('approved.all')}}">Phê duyệt bài đăng</a>

                @elseif (Auth::user()->role == 2)
                <a class="dropdown-item" href="{{route('mypost')}}">My posts</a>
                @else
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#upgradeModal">Interactive history</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#upgradeModal">Upgrate</a>
                {{-- <a class="dropdown-item" href="{{route('show.upgrade')}}">Upgrate</a> --}}
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
              </a>

            </div>
          </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Bạn có chắc chắn muốn thoát không?</div>
        <div class="modal-footer">
         <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Logout</button>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- MOdal upgrade -->
<div class="modal fade" id="upgradeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bạn đang là người xem, bạn có muốn chuyển sang người đăng bài không?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="mes" style="display: none;">
        Okk
      </div>
      <div class="modal-footer">
       <form id="logout-form" action="{{route('upgrade')}}" method="post">
        @csrf
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="accept">Accept</button>
      </form>

    </div>
  </div>
</div>
</div>

<!-- MOdal login -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Sign in</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        @include('auth.login')
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>

    </div>
  </div>
</div>


<!-- MOdal login -->
<div class="modal" id="myModal2">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title " >Sign up</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        @include('auth.register2')
      </div>
      @include('sweetalert::alert')


      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
      </div>

    </div>
  </div>
</div>

<!-- edit role -->
<div class="modal fade" id="upgrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upgrate role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="upgrade_submit" method="get" accept-charset="utf-8">
         <select class="custom-select">
          <option value="1" disabled>Admin</option>
          <option value="2">User</option>
          <option value="3">Mod</option>
        </select>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary">Save</button>
    </div>
  </div>

</div>
</div>

@yield('content')

@include('includes.footer')
</div>
</body>
</html>