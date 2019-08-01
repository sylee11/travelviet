<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
	<style type="text/css">
		.gallery img{
			margin-top: 20px;
			width: 200px;
			height: 200px;
			padding-right: 20px;
		}
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
	<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
	
</head>

@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 200px; text-align: left;">

	<h3 class="text-center"> Add new Post</h3>
	@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
	@endif
	@if (session('erro'))
	<div class="alert alert-danger">
		{{ session('erro') }}
	</div>
	@endif
	<FORM   action="{{route('account.addpost', $id = Auth::id() )}}" method="post" enctype="multipart/form-data">
		@csrf
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="cate1" class="col-md-4 col-form-label"  > Category </label>
				<select class="custom-select" class="col-md-2" id="cete1" name="category">
					@foreach($category as $ca)
					<option> {{$ca->name}} </option>
					@endforeach
				</select>
			</div>	
			<div class="form-group col-md-6">
				<label  for="name" class="col-form-label" > Tên địa điểm </label>
				<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required="" value="{{ old('name') }}" placeholder="Tên địa điểm">
				@error('name')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>
		</div>

		<div class="form-row " >
			<div class="form-group col-md-6">
				<label  for="address" class="col-form-label col-md-4 "> Địa chỉ </label>
				<input type="text"  class="form-control col-md-8 @error('address') is-invalid @enderror" placeholder="Full address" name="address" id="address" required="" value="{{ old('address') }}">
				@error('address')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror

			</div>
			<div class="form-group col-md-3">
				<label> Tỉnh, Thành Phố</label>
				<select  class="custom-select form-control" id="city" onchange="myFunction()" required="" value="{{ old('city') }}" name="city">
					<option value="">Tỉnh ,thành phố</option>
					@foreach($city as $ci)
					<option> {{$ci->name}}</option>
					@endforeach

				</select>

			</div>
			<div class="form-group col-md-3">
				<label>Quận, Huyện</label>

				<select class="custom-select form-control" name="districts_id" id="district" required="" >
					<option value="">Quận, huyện</option>						
				</select>
			</div>

		</div>
		<div class="form-group ">
			<label for="">Map</label>
			<input id="pac-input" class="controls" type="text" placeholder="Search Box">
			<div id="map"></div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-3">
				<!-- <label for="">Lat</label> -->
				<input type="hidden"  class="form-control input-sm" name="lat" id="lat" required="">
			</div>
			<div class="form-group col-md-3">
				<!-- <label for="">Lng</label> -->
				<input type="hidden" class="form-control input-sm" name="lng" id="lng" required="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-form-label "> Số điện thoại </label>
			<input type="tel" class="form-control col-md-8 @error('phone') is-invalid @enderror "  placeholder="034567890" name="phone" id="phone" value="{{ old('phone') }}">
			@error('phone')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group">
			<label class="col-sm-2 col-form-label @error('title') is-invalid @enderror"> Title bài đăng </label>
			<input type="text" class="form-control col-md-8" placeholder="Tiêu đề bài viết" name="title" id="title" required="" value="{{ old('title') }}" >
			@error('title')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>
		<div class="form-group">
			<label for="textarea"> Mô tả chi tiết </label>
			{{-- <textarea name="descrice" class="form-control @error('descrice') is-invalid @enderror" rows="20" id="descrice" required=""> </textarea> --}}
			<textarea class="form-control" rows="10" id="editor1" name="descrice" required>{{ old('descrice') }}</textarea>
			@error('descrice')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
		</div>


		{{-- <div class="custom-file"> 
			<div class="input-group control-group increment" >
				<img id="uploadPreview" style="width: 100px; height: 100px; display: none;"  />
				<input id="uploadImage" type="file" name="filename[]" class="form-control @error('filename') is-invalid @enderror" style="width: 100px; " onchange="PreviewImage()">
				@error('filename')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
				<div class="input-group-btn">  
					<button class="btn btn-success add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Add More picture</button>
				</div>
			</div>
			<div class=" clone" style="overflow: hidden;">
				<div class="control-group input-group" style="margin-top:10px">
					<img id="uploadPreview" style="width: 100px; height: 100px; display: none;"  />
					<input id=" uploadImage" type="file" multiple="" name="filename[]" class="form-control" onchange="PreviewImage()">
					<div class="input-group-btn"> 
						<button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
					</div>
				</div>
			</div>
		</div> --}}

		{{-- 				<form action="/" method="post" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">

		</form> --}}
		<h5 class="form-control-label"> Thêm ảnh cho bài viết</h5>
		<div class="form-control-file">
			<input multiple type="file"  id="gallery-photo-add" class="form-control" name="filename[]" required="" accept="image/x-png,image/jpeg">
			@error('filename')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
			@enderror
			<div class="gallery" style="display: flex; width: 200px;height: 200px;">
			</div>	
		</div>				

		<div style=" margin-top: 100px; margin-bottom: 50px;">
			<button type="submit" class="btn btn-primary" style="width: 100px;">Đăng bài</button>
			<button type="reset" class="btn btn-dark" style="width: 100px;"> Reset</button>


		</div>
	</FORM>

	{{-- 			<form action="/" method="post" class="dropzone" id="my-awesome-dropzone">

	</form> --}} 


</div>


<script type="text/javascript">

	$(document).ready(function() {

		$(".add").click(function(){ 
			var html = $(".clone").html();
			$(".increment").after(html);
		});

		$("body").on("click",".btn-danger",function(){ 
			$(this).parents(".control-group").remove();
		});

		var ab=$(".clone");
		ab.hide();


	});
	$('#gallery-photo-add').on('click', function() {
		$('.gallery img').hide();
	});

	$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

    	if (input.files) {
    		var filesAmount = input.files.length;

    		for (i = 0; i < filesAmount; i++) {
    			var reader = new FileReader();

    			reader.onload = function(event) {
    				$($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
    			}

    			reader.readAsDataURL(input.files[i]);
    		}
    	}

    };


    $('#gallery-photo-add').on('change', function() {
    	var a = $('div.gallery img');
    	a.hide();
    	imagesPreview(this, 'div.gallery');
    });
});

	function myFunction(){
		var cityID = document.getElementById("city").value; 
		console.log(cityID);   
		if(cityID){
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type:"GET",
				url:"{{route('acount.post.getcity')}}?cities_id="+cityID,
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
	};
	
</script>
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
        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">
window.onload = function(){


    	CKEDITOR.replace('editor1');

};
</script>
@endsection
