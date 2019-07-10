@extends('layouts.app')
@section('header')
<link rel="stylesheet" type="text/css" href="/css/custom/rating.css">
<link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">

@endsection
@section('content')
<?php
$photo_path = $data->unique('photo_path')->values();
$cmts = $data->unique('cmt')->values();
?>
<div class="container">
  <h1 class="my-4">{{$data[0]->title}}
    <small>by {{$data[0]->name}}</small>
  </h1>
  <div class="row">

    <div class="col">

      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

          <div class="carousel-item active">

            <img height="500px" class="d-block w-100" src="/{{$photo_path[0]->photo_path}}" alt="">

          </div>

          @for ($i=1;$i<$photo_path->count();$i++)
            <div class="carousel-item">

              <img height="500px" class="d-block w-100" src="/{{$photo_path[$i]->photo_path}}" alt="">

            </div>
            @endfor
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

    </div>

  </div>
  <!--<div class="row">
    <div class="col">
      <h3 class="my-3">{{$data[0]->place}}</h3>
      <p>{{$data[0]->describer}}</p>
    </div>
  </div> -->
  <div class="row">
    <div class="col">


      <div class="rating">
        @for($i=1;$i< $data[0]->rating;$i++)
          <span style="color:orange" class="fa fa-star "></span>

          @endfor
          <span>{{$data[0]->rating}}</span>


      </div>
    </div>

  </div>

  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#location">Location</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#rating">Rating</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="description" class="container tab-pane active"><br>
      <h3>{{$data[0]->place}}</h3>
      <p>{{$data[0]->describer}}</p>
    </div>
    <div id="location" class="container tab-pane fade"><br>
      <h3>Location</h3>

    </div>
    <div id="rating" class="container tab-pane fade"><br>
      <h3>Rating</h3>

    </div>
  </div>
  <div>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample">
      Comment
    </button>
    <div class="collapse" id="collapseExample">
      <div class="card card-body">
        <form>

          <span class="star-rating">
            <input type="radio" name="rating" value="1"><i></i>
            <input type="radio" name="rating" value="2"><i></i>
            <input type="radio" name="rating" value="3"><i></i>
            <input type="radio" name="rating" value="4"><i></i>
            <input type="radio" name="rating" value="5"><i></i>
            
          </span>
          <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="comment"></textarea>
          </div>
          <button>Send</button>
        </form>
      </div>
    </div>
  </div>
  @foreach ($cmts as $key=>$value)
  <div class="media border p-3">
    <img style="width:60px" class="mr-3 mt-3 rounded-circle" src="/{{$value->avatar}}" alt="">
    <div class="media-body">
      <h5 style='text-align=left' class="mt-0">{{$value->cmtname}}</h5>
      {{$value->cmt}}
    </div>
  </div>
  @endforeach



</div>

@push('scripts')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
<script> CKEDITOR.replace('editor1'); </script>
@endpush
<!--
<h1>{{$data[0]->title}}</h1>
<h2>{{$data[0]->describer}}</h2>
<h3>{{$data[0]->name}}</h3>
<h3>{{$data[0]->place}}</h3>
<h3>{{$data[0]->rating}}</h3> 
@foreach ($cmts as $key=>$value)
<p>{{$value->cmt}}</p>
@endforeach-->
@endsection