@extends('layouts.app')
@section('header')
<link rel="stylesheet" type="text/css" href="/css/custom/rating.css">
<link rel="stylesheet" type="text/css" href="/css/custom/front.css">
<style>
  #map {
    height: 500px;
  }
</style>

@endsection
@section('content')


<script>
  var map;
  // var infoWindow = new google.maps.InfoWindow();
  var latvalue = {{json_encode($data[0] -> lat)}};
  var longvalue = {{json_encode($data[0] -> longt)}};

  function initMap() {

    var uluru = {
      lat: latvalue,
      lng: longvalue
    };

    var map = new google.maps.Map(
      document.getElementById('map'), {
        zoom: 16,
        center: uluru
      });

    var marker = new google.maps.Marker({
      position: uluru,
      map: map
    });

  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxqyb5cmgcv7j9hY-GcPZYcNQlwyfWaT0&callback=initMap" async defer></script>

<?php
$photo_path = $data->unique('photo_path')->values();
$cmts = $data->unique('rating_id')->values();
?>
<div class="container" style='text-align:left;margin-top:75px;'>
  <h1 class="my-4">{{$data[0]->title}}
    <small style="text-align:right;font-size: 18px;">by <a style="color: black;text-decoration: none;" href="/user/{{$data[0]->user_id}}"> {{$data[0]->name}}</a>,{{ date('d-m-Y', strtotime($data[0]->create_at)) }}</small>

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
    <div class="col-6">


      <div style="margin: 20px 0;" class="rating">
        @for($i=1;$i<= $rating;$i++) <span style="color:orange;font-size: 50px" class="fa fa-star "></span>
          @if($rating -$i >= 0.5 && $rating -$i < 1)<span style="color:orange;font-size: 50px" class="fa fa-star-half-alt "></span>

            @endif
            @endfor
            <span>{{$rating}}</span>


      </div>
    </div>
    <div class="col-6" style="text-align: end;margin: 30px 0;">
      @if (session('success'))
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria_label="Close">
          <span aria_hidden="true">&times;</span>
        </button>
        {{ session('success') }}
      </div>
      @endif
      <div>
        <div class="row" style="justify-content: flex-end;margin-right: 5px;">
          <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button" data-size="large">
            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
          </div>
        </div>
        <div class="row" style="justify-content: flex-end;margin-right: -7px; margin-top: 10px;">
          <a href="{{route('invite')}}" title="" style="right: 0px;" class="btn btn-danger" data-toggle="modal" data-target="#invite">Share email</a>
        </div>
      </div>

    </div>
    <div style="margin: 20px 0 100px 0;width: 100%;">
      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#location">Location</a>
        </li>

      </ul>

      <!-- Tab panes -->
      <div style="height:500px;" class="tab-content">
        <div id="description" class="container tab-pane active"><br>
          <h3>{{$data[0]->place}}</h3>
          <p>{{$data[0]->describer}}</p>
        </div>
        <div id="location" class="container tab-pane fade"><br>
          <h3>Location</h3>
          <div id="map"></div>
        </div>

      </div>
    </div>
  </div>
  <div class="container">
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" style="margin-bottom: 20px;">
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
          <!-- <input type="hidden" name="post_id" value="{{$data[0]->id}}"> -->
          <?php session(['post_id' => $data[0]->id]); ?>

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

  <div class="container" style="margin-bottom: 50px;">
    @if($cmts[0]->cmt !=NULL || $cmts[0]->rate != NUll)
    @foreach ($cmts as $key=>$value)
    <div class="media border p-3">

      @if($value->avatar)
      <img style="width:60px" class="mr-3 mt-3 rounded-circle" src="{{$value->avatar}}" alt="">
      @else
      <img style="width:60px" class="mr-3 mt-3 rounded-circle" src="/picture/images.png" alt="">
      @endif
      <div class="media-body">

        <h5 style='padding-top:20px;display:inline-block;' class="mt-0"><a href="/user/{{$value->cmtid}}">{{$value->cmtname}}</a></h5>

        <small>{{ date('d-m-Y', strtotime($value->created_at)) }}</small>





        @for($i=1;$i<= $value->rate;$i++)
          <span style="color:orange" class="fa fa-star "></span>

          @endfor

          <p style='padding-top:10px'>{!!$value->cmt!!}</p>
      </div>
    </div>
    @endforeach
    @endif
  </div>


  <div class="container-fluid">
    <div style="text-align: center;margin-top:50px;">
      <h2>Những bài viết liên quan</h2>
    </div>

    <div class="row" style="justify-content: center;">
      @if($post_relate->count() !== 0)
      @foreach ($post_relate as $record)
      <div class="col-sm-3" style="margin:50px 0;">
        <div class="card-img" style="height:280px;">
          <a href="{{route('detail',$record->id)}}" title="" style="text-decoration: none;">
            <div style="height: 200px;">
              <img class="card-img-top list_images" src="/{{ $record->photo_path }}" alt="{{$record->title}}" style="height: 200px;">
            </div>

            <div class="card-body">

              <h5 class="card-title text-primary">

                <span style="display:block;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;font-size: 16px;color:black;">
                  {{$record->title}}
                </span>
              </h5>
              <div class="rating">
                @for($i=0;$i< ceil($record->rate);$i++)
                  <span class="fa fa-star checked"></span>
                  @endfor
                  @for($i=ceil($record->rate);$i< 5;$i++) <span class="fa fa-star unchecked"></span>
                    @endfor
              </div>

              <p class="card-text">
              </p>

            </div>
          </a>

        </div>
      </div>
      @endforeach
      @else
      <p>Không có bài viết liên quan</p>
      @endif
    </div>
  </div>

</div>
{{-- invite Modal --}}
<div class="modal fade" id="invite" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mời bạn bè</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <form action="{{ route('process') }}" method="post">
              {{ csrf_field() }}
              <div class="row" style="margin-bottom: 20px;">

                <div class="col">
                  <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="small">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" class="fb-xfbml-parse-ignore">Chia sẻ</a>
                  </div>
                  {{-- <a href="" class="btn btn-social btn-facebook">
                <i class="fab fa-facebook-f"></i>
                Share with Facebook
              </a> --}}
                </div>
              </div>

              <div class="row">
                <div class="col-8">
                  <label for="email">Người nhận:</label>
                  <input type="email" name="email" />
                </div>
                <div class="col-4">
                  <button type="submit" class="btn btn-info">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.3"></script>