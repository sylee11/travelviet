@extends('layouts.admin')
@section('content')
<h1>Detail User</h1>


<form action="{{route('admin.place.detail', $place->id)}}" method="get">
	{{csrf_field()}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $place->name }}" disabled="" class="form-control" required autocomplete="name">
  </div>
  
  
  <div class="form-group">
    <label for="">Address</label>
    <input id="text" type="text" name="address" value="{{ $place->address }}" class="form-control" required autocomplete="address" disabled="">
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
    <label for="">Category</label>
    <input  class="form-control" type="text" name="category_id" disabled="" value="{{$place->category->name}}" >
  </div>
    <div class="form-group col-md-3">
      <label for="">City</label>
      <input type="text" name="" class="form-control" value="{{$place->districts->cities->name}}" disabled="">
      
    </div>
    <div class="form-group col-md-3">
      <label for="">District</label>
      <input type="text" class="form-control" name="districts_id" disabled="" value="{{$place->districts->name}}">
     
    </div>
  </div>
  <div class="form-group ">
    <label for="">Map</label>
    
    <div id="map"> </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
<!--       <label for="">Lat</label> -->
      <input type="hidden" value="{{$place->lat}}" class="form-control input-sm" name="lat" id="lat" required="" disabled="">
    </div>
    <div class="form-group col-md-3">
      <!-- <label for="">Lng</label> -->
      <input type="hidden" value="{{$place->longt}}" class="form-control input-sm" name="lng" id="lng" required="" disabled="">
    </div>
  </div>

  
    <a href="/admin/place"  class="btn btn-danger" style="color: white">Cancel</a>
  
</form>


  

<style type="text/css">
  #map{
    border:1px solid red;
    
    height: 500px;
  }
   
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-rW15K4v7WHlCWmnCYMLzyR0pU1cPpeI&libraries=places&callback=initAutocomplete"
async defer></script>


<script type="text/javascript">
 
  var latvalue = {!! json_encode($place->lat) !!}; 
  var lngvalue = {!! json_encode($place->longt) !!};
  var namevalue = {!! json_encode($place->name) !!};
  var addressvalue = {!! json_encode($place->address) !!};
  var infowindow = new google.maps.InfoWindow;
  function initAutocomplete() {
   
    var pos = {
      lat: latvalue,
      lng: lngvalue
    };
        var map = new google.maps.Map(document.getElementById('map'), {
          center: pos,
          zoom: 16,
          mapTypeId: 'roadmap'
        });
        var marker = new google.maps.Marker({position: pos, map: map });
        var infowindow = new google.maps.InfoWindow({
          content:'<b>Tên địa điểm:</b> '+namevalue+ '<br><b>Địa chỉ:</b>'+addressvalue+ '<br>Vị trí địa điểm: ' +'Lat :' + latvalue+
          ' Long: ' + lngvalue
        });
        infowindow.open(map,marker); 
       
       }
   
</script>
@endsection
