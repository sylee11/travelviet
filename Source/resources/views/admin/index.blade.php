@extends('layouts.admin')
@section('content')
<!-- Icon Cards-->
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-primary o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-comments"></i>
        </div>
        <div class="mr-5">Users</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="{{route('admin.user.index')}}">
        <span class="float-left">View Details</span>
        <span class="float-right">
          <i class="fas fa-angle-right"></i>
        </span>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-warning o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-list"></i>
        </div>
        <div class="mr-5">Posts</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="{{route('admin.post.index')}}">
        <span class="float-left">View Details</span>
        <span class="float-right">
          <i class="fas fa-angle-right"></i>
        </span>
      </a>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
   <span class="float-left">
      <label>Chọn tháng: </label>
    <input id="bday-month" type="month" name="bday-month" style="height:40px;width: 200px">
   </span>
    <span class="float-right">
      <label>Chọn năm: </label>
    <input type="text" id="date"> <br>
   </span>
  </div>
  <div class="col-xl-3 col-sm-6 mb-3">
    <a href="" title="" class="btn btn-primary" style="height:40px;">Year</a>

  </div>
</div>
</div>

<!-- Area Chart-->
<div class="card mb-3">
  <div class="card-header">
    <i class="fas fa-chart-area"></i>
  Area Chart</div>
  <div class="card-body">
    <canvas id="myAreaChart" width="100%" height="30">
      <div id="container" data-order="{{ $user_year }}"></div>
    </canvas>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
<!-- End Area Chart-->
</div>
@endsection