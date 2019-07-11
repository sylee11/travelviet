@extends('layouts.app')
@section('header')
<link rel="stylesheet" type="text/css" href="/css/custom/rating.css">

@endsection
@section('content')
<?php
$photo_path = $data->unique('photo_path')->values();
$cmts = $data->unique('cmt')->values();
?>
<div style='text-align:left;margin-top:75px;' class="container">
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

  <div class="row">
    <div class="col">


      <div style="margin: 20px 0;" class="rating">
        @for($i=1;$i<= $rating;$i++) <span style="color:orange;font-size: 50px" class="fa fa-star "></span>
          @if($rating -$i >= 0.5 && $rating -$i < 1)<span style="color:orange;font-size: 50px" class="fa fa-star-half-alt "></span>

            @endif
            @endfor
            <span>{{$rating}}</span>


      </div>
    </div>

  </div>
  <div style="margin: 20px 0 100px 0;" class="">
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#location">Location</a>
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

    </div>
  </div>
  <div>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample">
      Comment
    </button>
    <div class="collapse" id="collapseExample">
      <div class="card card-body">

        @if(Auth::check())
        @if($user_rate)
        <p>Your rate:
          @for($i=1;$i<= $user_rate->rating;$i++) <span style="color:orange;font-size: 50px" class="fa fa-star "></span>
            @if($user_rate->rating -$i >= 0.5 && $user_rate->rating -$i < 1)<span style="color:orange;font-size: 50px" class="fa fa-star-half-alt "></span>

              @endif
              @endfor
              <span>{{$user_rate->rating}}</span></p>
        @endif
        <form action="/detail/rate" method="POST">
          @csrf
          <label for="">Rating:</label>
          <input type="hidden" name="post_id" value="{{$data[0]->id}}">
          <input type="hidden" name="user_id" value="{{Auth::id()}}">

          <span class="star-rating">
            <input type="radio" name="rating" value="1"><i></i>
            <input type="radio" name="rating" value="2"><i></i>
            <input type="radio" name="rating" value="3"><i></i>
            <input type="radio" name="rating" value="4"><i></i>
            <input type="radio" name="rating" value="5"><i></i>

          </span>

          <div class="form-group">
            <label for="">Comment:</label>


            <textarea class="form-control" rows="5" id="" name="commentarea" required></textarea>


          </div>
          <button>Send</button>
        </form>
        @else
        <a style="width:150px;" class="btn btn-primary" href="/login">Please Login</a>
        @endif
      </div>
    </div>
  </div>
  @foreach ($cmts as $key=>$value)
  <div class="media border p-3">
    <img style="width:60px" class="mr-3 mt-3 rounded-circle" src="/{{$value->avatar}}" alt="">
    <div class="media-body">

      <h5 style='padding-top:20px;display:inline-block;' class="mt-0">{{$value->cmtname}}</h5>





      @for($i=1;$i<= $value->rate;$i++)
        <span style="color:orange" class="fa fa-star "></span>

        @endfor



        <p style='padding-top:10px'>{{$value->cmt}}</p>
    </div>
  </div>
  @endforeach



</div>


<!-- <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> -->

<script>
  // window.onload = function() {
  //   CKEDITOR.replace('commentarea');
  // };
</script>



@endsection