<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Travel Admin - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  
  <!-- Page level plugin CSS-->
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">


  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>
  <link href="{{asset('css/bootstrap.min.css')}}" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">



</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{ route('admin.index') }}">Administrator</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-bell fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
        </div>
      </li>
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <span class="badge badge-danger">9+</span>
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{route('home.page')}}">Home</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item" style="{{Request::is('admin') ? 'background-color: #4F4E4E;' : ''}}">
        <a class="nav-link" href="{{ route('admin.index') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item" style="{{Request::is('admin/user*') ? 'background-color: #4F4E4E;' : ''}}">
        <a class="nav-link" href="{{ route('admin.user.index') }}">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>User</span></a>
        </li>
        <li class="nav-item" style="{{Request::is('admin/post*') ? 'background-color: #4F4E4E;' : ''}}">
          <a class="nav-link" href="{{ route('admin.post.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Post</span></a>
          </li>
          <li class="nav-item" style="{{Request::is('admin/category*') ? 'background-color: #4F4E4E;' : ''}}">
            <a class="nav-link" href="{{ route('admin.category.index') }}">
              <i class="fas fa-fw fa-table"></i>
              <span>Category</span></a>
            </li>
            <li class="nav-item" style="{{Request::is('admin/place*') ? 'background-color: #4F4E4E;' : ''}}">
              <a class="nav-link" href="{{ route('admin.place.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Place</span></a>
              </li>
              <li class="nav-item" style="{{Request::is('admin/rating*') ? 'background-color: #4F4E4E;' : ''}}">
                <a class="nav-link" href="{{ route('admin.rating.index') }}">
                  <i class="fas fa-fw fa-table"></i>
                  <span>Rating</span></a>
                </li>
              </ul>

              <div id="content-wrapper">

                <div class="container-fluid">

                  <!-- Breadcrumbs-->
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="{{ route('admin.index') }}">Dashboard</a>
                    </li>
                    <li class="active">@yield('title')</li>
                  </ol>

                  <!-- Icon Cards-->

                  <!-- Area Chart Example-->
                  @yield('content')
                  <!-- /.container-fluid -->

                  <!-- Sticky Footer -->
                  <footer class="sticky-footer">
                    <div class="container my-auto">
                      <div class="copyright text-center my-auto">
                        <span>Copyright © Your Website 2019</span>
                      </div>
                    </div>
                  </footer>

                </div>
                <!-- /.content-wrapper -->

              </div>
              <!-- /#wrapper -->

              <!-- Scroll to Top Button-->
              <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
              </a>

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
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
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
          </div>

          <!-- Bootstrap core JavaScript-->
          <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
          <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

          <!-- Core plugin JavaScript-->
          <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

          <!-- Page level plugin JavaScript-->
          <script src="{{ asset('/vendor/chart.js/Chart.min.js') }}"></script>
          <script src="{{ asset('/vendor/datatables/jquery.dataTables.js') }}"></script>
          <script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.js') }}"></script>

          <!-- Custom scripts for all pages-->
          <script src="{{ asset('/js/sb-admin.min.js') }}"></script>

          <!-- Demo scripts for this page-->
          <script src="{{ asset('/js/demo/datatables-demo.js') }}"></script>
          <script src="{{ asset('/js/demo/chart-area-demo.js') }}"></script>
          <!--  jquery -->
          @stack('scripts')

        </body>

        </html>
