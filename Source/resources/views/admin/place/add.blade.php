@extends('layouts.admin')
@section('content')
<h1>Thêm địa điểm</h1>
@if(count($errors)>0)
<div class="alert alert-danger">
	@foreach($errors->all() as $err)
	{{$err}} <br>
	@endforeach
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-success">
	{{Session::get('message')}}
</div>
@endif
<form action="{{route('admin.place.add')}}" method="post" >
	<input type="hidden" name="_token" value="{{ csrf_token()}}">
	<div class="form-group">
		<label for="">Tên địa điểm </label>
		<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  required autofocus >
	</div >
	
	<div class="form-group">
		<label for="">Address </label>
		<input id="address" type="text" class="form-control" name="address" value="{{old('address')}}"    required autofocus >
	</div>
	<div class="form-row">
		<div class="form-group col-md-4">
		<label for="">Category</label>
		<select class="custom-select" name="category_id"  >
			<option name="category" >Category</option>
			@if($category)
			@foreach ($category as $ca)
			<option  value="{{$ca->id}}" >{{$ca->name}}</option>
			@endforeach
			@endif
		</select>
	    </div>
		<div class="form-group col-md-3">
			<label for="">City</label>
			<select class="custom-select" name="city_id" id="city">
				<option value="">City</option>
				@if($city)
				@foreach ($city as  $record)
				<option value="{{$record->id}}">{{$record->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="">District</label>
			<select class="custom-select" name="districts_id" id="district">
				<option value="">District</option>
				
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
			<input type="hidden" class="form-control input-sm" name="lat" id="lat" required="">
		</div>
		<div class="form-group col-md-3">
			<input type="hidden" class="form-control input-sm" name="lng" id="lng" required="">
		</div>
	</div>
	<button type="submit" class="btn btn-primary">Add</button>
	
    <a href="/admin/place" class="btn btn-danger" style="color: white">Cancel</a>
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
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};
				$('#lat').val(position.coords.latitude);
				$('#lng').val(position.coords.longitude);
	
				var map = new google.maps.Map(document.getElementById('map'), {
					center: pos,
					zoom: 16,
					mapTypeId: 'roadmap'
				});
				// var marker = new google.maps.Marker({position: pos, map: map,draggable: true });
                
				var marker = new google.maps.Marker({
					position: pos,
					draggable: true,	
					map: map
				});
                var infowindow = new google.maps.InfoWindow({
						content: 'Vị trí của bạn ' +'<br>Latitude: ' + position.coords.latitude+
						'<br>Longitude: ' + position.coords.longitude
					});
					infowindow.open(map,marker);
				
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
					 lat =marker.getPosition().lat();
					 lng =marker.getPosition().lng();

					$('#lat').val(lat);
					$('#lng').val(lng);
					if ( position.coords.latitude!=lat ||position.coords.longitude!=lng) {
						infowindow.close();
						infowindow = new google.maps.InfoWindow({
							content: 'Vị trí bạn muốn chọn' +'<br>Latitude: ' + lat+
						'<br>Longitude: ' + lng
						});
						// marker.addListener('click', function() {
							infowindow.open(marker.get('map'), marker);
						//});
                  }
				});
				
				
			}, function() {
				handleLocationError(true, infoWindow, map.getCenter());
			});
         

		}
	}
</script>
@endsection

