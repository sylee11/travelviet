@extends('layouts.admin')
@section('content')
<h1>Chỉnh sửa User</h1>
<!-- @if (session('thongbao'))
 <div class="alert alert-danger">
 	{{session('thongbao')}}
 </div>
 @endif -->

 @if(count($errors)>0)
 <div class="alert alert-danger">
  @foreach($errors->all() as $err)
  {{$err}} <br>
  @endforeach
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-danger">
	{{Session::get('message')}}
</div>
@endif

<form action="{{route('admin.place.edit', $place->id)}}" method="post">
	{{csrf_field()}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $place->name }}" class="form-control" required autocomplete="name">
  </div>
  <div class="form-group col-md-2">
    <label for="">Category</label>
    <select class="custom-select" name="category_id">
      <option value="{{$place->category_id}}">{{$place->category->name}}</option>
      @if($category)
      @foreach ($category as $ca)
      <option value="{{$ca->id}}">{{$ca->name}}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-group">
    <label for="">Address</label>
    <input id="text" type="text" name="address" value="{{ $place->address }}" class="form-control" required autocomplete="address">
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="">City</label>
      <select class="custom-select" name="" id="city">
        <option value="{{$place->districts_id}}">{{$place->districts->cities->name}}</option>
        @if($city)
        @foreach ($city as $ci)
        <option value="{{$ci->id}}">{{$ci->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="">District</label>
      <select class="custom-select" name="districts_id" id="district">
        <option value="{{$place->districts_id}}">{{$place->districts->name}}</option>
      </select>
    </div>
  </div>
  <div class="form-group ">
    <label for="">Map</label>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"> </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
     <!--  <label for="">Lat</label> -->
      <input type="hidden" value="{{$place->lat}}" class="form-control input-sm" name="lat" id="lat" required="">
    </div>
    <div class="form-group col-md-3">
      <!-- <label for="">Lng</label> -->
      <input type="hidden" value="{{$place->longt}}" class="form-control input-sm" name="lng" id="lng" required="">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">
    <i class="fa fa-btn fa-sign-in"></i>Update
  </button>
  <button type="submit" class="btn btn-danger">
    <a href="/admin/place" style="color: white">Cancel</a>
  </button>

</form>

<script type="text/javascript">
  $('#city').change(function(){
    var cityID = $(this).val();    
    if(cityID){
      $.ajax({
       type:"GET",
       url:"{{route('admin.place.getcity')}}?cities_id="+cityID,
       success:function(res){               
        if(res){
          $("#district").empty();
          $("#district").append('<option>District</option>');
          $.each(res,function(key,value){
            $("#district").append('<option value="'+key+'">'+value+'</option>');
          });
        }else{
         $("#district").empty();
       }
     }
   });
    }else
    {
      $("#district").empty();    
    }      
  });
  
</script>
<style type="text/css">
  #map{
    border:1px solid red;
    
    height: 500px;
  }
   #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
      
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-rW15K4v7WHlCWmnCYMLzyR0pU1cPpeI&libraries=places&callback=initAutocomplete"
async defer></script>


<script type="text/javascript">
  var infowindow = new google.maps.InfoWindow;
  
  
  function initAutocomplete() {
   
    var pos = {
      lat: 16.02,
      lng: 108.13
    };
        var map = new google.maps.Map(document.getElementById('map'), {
          center: pos,
          zoom: 10,
          mapTypeId: 'roadmap'
        });
        var marker = new google.maps.Marker({position: pos, map: map,draggable: true });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
                
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map.addListener('bounds_changed', function() {
                 searchBox.setBounds(map.getBounds());
                  });


        google.maps.event.addListener(searchBox,'places_changed',function(){
          var places = searchBox.getPlaces();
          var bounds = new google.maps.LatLngBounds();

          var i,place;
          for (i=0;place=places[i];i++){
            bounds.extend(place.geometry.location);
              marker.setPosition(place.geometry.location);//set marker position new
            }
            map.fitBounds(bounds);
            map.setZoom(16);
        });
        google.maps.event.addListener(marker,'position_changed',function(){
          var lat =marker.getPosition().lat();
          var lng =marker.getPosition().lng();

          $('#lat').val(lat);
          $('#lng').val(lng);
        });
       }
   
</script>
@endsection
