@extends('layouts.admin')
@section('content')

<div class="row">
  <div class="col-xl-3 col-sm-6 mb-3">
    <div class="card text-white bg-primary o-hidden h-100">
      <div class="card-body">
        <div class="card-body-icon">
          <i class="fas fa-fw fa-comments"></i>
        </div>
        <div class="mr-5">Users</div>
      </div>
      <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.user.index') }}">
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
      <a class="card-footer text-white clearfix small z-1" href="{{ route('admin.post.index') }}">
        <span class="float-left">View Details</span>
        <span class="float-right">
          <i class="fas fa-angle-right"></i>
        </span>
      </a>
    </div>
  </div>
</div>

<form action="/admin/chart" method="GET">
  <label>Table</label>
  <select required name="dbname">
    <option value="" selected disabled hidden>Choose here</option>
    <option value="users">User</option>
    <option value="ratings">Rating</option>
    <option value="posts">Post</option>
  </select>
  
  <br>

  <input type="month" name="begin" required>
  <input type="month" name="end" required>
  <button class="btn-success" type="submit" formaction="/admin/chart" formmethod="GET">Submit</button>
</form>

<div style="height: 400px">
  @if(isset($chart))
  {!! $chart->container() !!}
  <div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    @endif




    @endsection