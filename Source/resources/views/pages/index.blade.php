@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('pages.home')
@section('content-section')

<div class="home">
	<div class="container-fluid" id="topplace">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;" ><h2>NHỮNG ĐỊA ĐIỂM ĐƯỢC ĐÁNH GIÁ CAO</h2></div>

		<div class="row" style="justify-content: center;">
			@if($top_rating->count() !== 0)
			@foreach ($top_rating as $record)
			<div class="col-sm-3" style="margin:50px 0;">
				<div class="card-img" style="height:280px;" id="card-img">
					<a href='{{route("detail",$record->slug)}}' title="" style="text-decoration: none;">
						<div style="height: 200px;">
							<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="{{$record->title}}" style="height: 200px;">
						</div>

						<div class="card-body">

							<h5 class="card-title">

								<span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap; font-size: 16px;color: black;">
									{{$record->title}}
								</span>
							</h5>
							<div class="rating">
								@for($i=0;$i< ceil($record->avg_rating);$i++)
								<span class="fa fa-star checked"></span>
								@endfor
								@for($i=ceil($record->avg_rating);$i< 5;$i++)
								<span class="fa fa-star unchecked"></span>
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
			<div class="col-sm">
				<p>Không có dữ liệu</p>
			</div>
			@endif
		</div>
	</div>



	<div class="container-fluid" id="new_post">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>NHỮNG BÀI VIẾT MỚI NHẤT</h2></div>

		<div class="row" style="justify-content: center;">
			@if($new_post->count() !== 0)
			@foreach ($new_post as $record)
			<div class="col-sm-4" style="margin:50px 0;">
				<div class="card-img" id="card-img" >
					<a href="{{route('detail',$record->slug)}}" title="" style="text-decoration: none;"id="pic">
						<div style="height: 200px;">
							<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="{{$record->title}} " >
						</div>

						<div class="card-body">

							<h5 class="card-title text-primary">

								<span style="display:block;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;font-size: 16px;color: black;">
									{{$record->title}}
								</span>
							</h5>
							<div class="rating">
								@for($i=0;$i< ceil($record->avg_rating);$i++)
								<span class="fa fa-star checked" ></span>
								@endfor
								@for($i=ceil($record->avg_rating);$i< 5;$i++)
								<span class="fa fa-star unchecked" ></span>
								@endfor
							</div>

							<p class="card-text">
							</p>

						</div>
					</a>

				</div>
			</div>
			@endforeach
		</div>
		@if($all_post->count() > 6)
		<div style="text-align: end; margin-top: -50px;margin-bottom: 50px;">
			<a href="{{route('all.posts')}}" title="" style="font-size: 12px;color: red;text-decoration: none;">
				Tất cả
				<i class='fas fa-angle-double-right' style='font-size:10px'></i>
			</a>
		</div>
		<div>
			<button type="button" class="btn btn-danger" id="all">Xem thêm</button>
		</div>
		@endif
		@else
		<div class="col-sm">
			<p>Không có dữ liệu</p>
		</div>
		@endif
	</div>

	<div class="container-fluid" id="all_post" style="display: none;">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>NHỮNG BÀI VIẾT MỚI NHẤT</h2></div>

		<div class="row">
			@if($all_post->count() !== 0)
			@foreach ($all_post as $record)
			<div class="col-sm-4" style="margin:50px 0;">
				<div class="card-img" style="height:280px;"  id="card-img">
					<a href="{{route('detail',$record->slug)}}" title="" style="text-decoration: none;">
						<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="{{$record->title}}" style="height: 200px;">

						<div class="card-body">

							<h5 class="card-title text-primary">

								<span style="display:block;text-overflow: ellipsis;overflow: hidden; white-space: nowrap;font-size: 16px;color: black;">
									{{$record->title}}
								</span>
							</h5>
							<div class="rating">
								@for($i=0;$i< ceil($record->avg_rating);$i++)
								<span class="fa fa-star checked" ></span>
								@endfor
								@for($i=ceil($record->avg_rating);$i< 5;$i++)
								<span class="fa fa-star unchecked" ></span>
								@endfor
							</div>

							<p class="card-text">
							</p>

						</div>
					</a>

				</div>
			</div>
			@endforeach
		</div>
		@if($all_post->count() > 6)
		<div style="text-align: end; margin-top: -50px;margin-bottom: 50px;">
			<a href="{{route('all.posts')}}" title="" style="font-size: 12px;color: red;text-decoration: none;">
				Tất cả
				<i class='fas fa-angle-double-right' style='font-size:10px'></i>
			</a>
		</div>
		<div>
			<button type="button" class="btn btn-danger" id="new">Thu gọn</button>
		</div>
		@endif
		@else
		<div class="col-sm">
			<p>Không có dữ liệu</p>
		</div>
		@endif
	</div>
</div>
	<div class="container top_city">
		<div style="color: #b3b3ba;"><h2>Điểm đến nhiều nhất</h2></div>
		<!-- Full-width images with number text -->
		@if (count($city_post) !== 0)
		@foreach ($city_post as $key => $element)
		<div class="mySlides" style="padding: 0px;">
			<a href="{{route('show.posts',$element->id)}}" title="{{ $element->name }}">
				<div class="numbertext">{{$key+1}} / {{count($city_post)}}</div>
				<img src="{{ $element->photo_path }}" style="width:100%">
			</a>
		</div>
		@endforeach
		@else
		<div>Không có dữ liệu</div>	
		@endif

		<!-- Next and previous buttons -->
		<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
		<a class="next" onclick="plusSlides(1)">&#10095;</a>

		<!-- Image text -->
		<div class="caption-container">
			<p id="caption"></p>
		</div>

		<!-- Thumbnail images -->
		<div class="row" style="justify-content: center;">
			@if (count($city_post) !== 0)
			@foreach ($city_post as $key => $element)
			<div class="col-2 " style="padding: 0px;">
				<img class="demo cursor" src="{{ $element->photo_path }}" style="width:100%;height: 100px;" onclick="currentSlide({{$key+1}})" alt="{{ $element->name }}">
			</div>
			@endforeach
			@else
			<div>Không có dữ liệu</div>
			@endif
		</div>
	</div>

	<div class="d-flex" style="background-image: url(../picture/front/header2.jpg); width: 100%; height: 500px; margin-top: 100px;" > 
		<div class="container" style="margin-bottom: 50px;">
			<div style="text-align: center;margin-top:50px;">
				<h2 class="section-heading" style="color: white;">Top thành viên tích cực</h2>
				<hr align="content" width="20%" color="#3997A6" size="0.1px" style="padding-bottom: 1px;"> 
			</div>
			{{-- <div style="text-align: center;margin-top:50px;color: #b3b3ba;margin-bottom: 50px;"><h2>Blog có số lượng bài viết nhiều nhất</h2></div> --}}
			<div class="row " style="justify-content: center;margin-left: 20%; width:60%; border: 2px dotted #D3D3D3; padding: 20px;" >
				@if(count($top_user) !== 0)
				@foreach($top_user as $record)
				<div style="padding: 0 15px;">
					<a href="/user/{{$record->id}}" title="" style="text-decoration: none;">
						@if (!empty($record->avatar))
						<img src="{{ $record->avatar }}" alt="Avatar" class="avatar" title="{{!empty($record->name)?$record->name:'no name'}}" style="width: 60px;height:60px;border-radius: 50%;">

						@else
						<img src="{{ asset('picture/images.png') }}" alt="Avatar" class="avatar" title="{{!empty($record->name)?$record->name:'no name'}}" style="width: 60px;height:60px;border-radius: 50%;">
						@endif
					</a>
				</div>
				@endforeach
				@else
				<div class="col-sm">
					<p>Không có dữ liệu</p>
				</div>
				@endif
			</div>
			<div class="row" style="margin-top: 100px;" id="invite">
				<div class="col-lg-8">
					<p  style="color: white; font-size: 30px;">Bạn muốn bài viết của mình xuất hiện ở đây?</p>	
					<p style="color: white; font-size: 18px;"> Chia sẻ hình ảnh, những chuyến đi để chia sẻ những trải nghiệm của mình đến mọi người! </p>
				</div>
				@if(Auth::check())
				<a  class="btn btn-success " style="height: 50px; margin-top: 30px;margin-left: 100px;"  href="{{ route('mypost') }}"> Tham gia ngay !</a>
				@else
				<a  class="btn btn-success " style="height: 50px; margin-top: 30px;margin-left: 100px;" data-toggle="modal" data-target="#myModal" href="{{ route('login') }}"> Tham gia ngay !</a>
				@endif
			</div>
		</div>
	</div>
	

<div class="container">
	<div style="text-align: center;margin-top:50px;" id="contact">
		<h2 class="section-heading" style="color: #b3b3ba;">Contact Us</h2>
		<hr align="content" width="20%" color="#3997A6" size="0.1px" style="padding-bottom: 1px; margin-bottom: 40px;"> 
	</div>
	<div class="row"  style="justify-content: center;">
		<div class="col-sm-4 text-center">
			<a href="tel:+91-8238566835"><i style="color: #3997A6;" class="fa fa-phone fa-3x sr-contact"></i></a>
			<p>+84-199001950</p>
		</div>
		<div class="col-sm-4 text-center">
			<a href="info@travelbrewery.com"><i style="color: #3997A6;" class="fa fa-envelope fa-3x sr-contact"></i></a>
			<p>Namoccho@travelViet.com</p>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#all").click(function(){
			$('#new_post').hide();
			$('#all_post').show();
		});
		$("#new").click(function(){
			$('#new_post').show();
			$('#all_post').hide();
		});

	});
	var slideIndex = 1;
	showSlides(slideIndex);

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}

	function currentSlide(n) {
		showSlides(slideIndex = n);
	}

	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("demo");
		var captionText = document.getElementById("caption");
		if (n > slides.length) {slideIndex = 1}
			if (n < 1) {slideIndex = slides.length}
				for (i = 0; i < slides.length; i++) {
					slides[i].style.display = "none";
				}
				for (i = 0; i < dots.length; i++) {
					dots[i].className = dots[i].className.replace(" active", "");
				}
				slides[slideIndex-1].style.display = "block";
				dots[slideIndex-1].className += " active";
				captionText.innerHTML = dots[slideIndex-1].alt;
			}
		</script>
		@endsection
