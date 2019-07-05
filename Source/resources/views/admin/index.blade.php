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
      <a class="card-footer text-white clearfix small z-1" href="#">
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
      <a class="card-footer text-white clearfix small z-1" href="#">
        <span class="float-left">View Details</span>
        <span class="float-right">
          <i class="fas fa-angle-right"></i>
        </span>
      </a>
    </div>
  </div>
</div>

<!-- Area Chart Example-->
<!--        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
        <div class="mr-5">Posts</div>
      </div>
-->

<form action="" method="GET">
  <label>Table</label>
  <select name="dbname" >
  <option value="" selected disabled hidden>Choose here</option>
    <option value="users">User</option>
    <option value="ratings">Rating</option>
    <option value=""></option>
    <option value=""></option>
  </select>
  <label>Year</label>
  <select name="year" >
  <option value="" selected disabled hidden>Choose here</option>
    <option value="2019">2019</option>
    <option value="2018">2018</option>
    <option value=""></option>
    <option value=""></option>
  </select>
  
  <input class="btn-success" type="submit">
</form>

<div style="height: 400px">
  {!! $chart->container() !!}
  <div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}


   


    @endsection
