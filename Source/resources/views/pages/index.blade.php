@extends('pages.home')
<style type="text/css" >
	.list_images {
		opacity: 0.7;
	}

	.list_images:hover {
		opacity: 1;
	}
	p{
		color: #090707;
	}
	.checked {
		color: orange;
	}
</style>
@section('content-section')
<div class="container">
	<div style="text-align: left;margin-top:50px;"><h2>Top Reviewer</h2></div>

	<div class="row">
		@if($rating)
		@foreach ($rating as $record)
		<div class="col-sm-4" style="margin:50px 0;">
			<div class="card" style="width: 20rem;height:350px;">
				<a href="#" title="" style="text-decoration: none;">
					<img class="card-img-top list_images" src="{{ asset('picture/front/image1.jpg') }}" alt="smaple image">

					<div class="card-body" >

						<h5 class="card-title text-primary">{{$record->post->title}}</h5>
						<div class="rating">
							@for($i=0;$i< $record->rating;$i++)
							<span class="fa fa-star checked" ></span>
							@endfor
							@for($i=$record->rating;$i< 5;$i++)
							<span class="fa fa-star" ></span>
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
		<div></div>
		@endif
	</div>
</div>

<div class="container">
	<div style="text-align: left;margin:50px 0;"><h2>New posts</h2></div>
	<div class="row">
		@if($a)
		@foreach ($a as $record)
		<div class="col-sm-4" style="margin:50px 0;">
			<div class="card" style="width: 20rem;height:350px;">
				<a href="/detail/2" title="" style="text-decoration: none;">
					<img class="card-img-top list_images" src="{{ asset('picture/front/image2.jpg') }}" alt="smaple image">

					<div class="card-body">

						<h5 class="card-title text-primary">{{$record->post->title}}</h5>
						
						<p class="card-text">
						</p>

					</div>
				</a>

			</div>
		</div>
		@endforeach
		@endif
	</div>
</div>

<div class="container">
	<div style="text-align: left;margin:50px 0;"><h2>Top Mod</h2></div>
	<div class="row" style="margin:0 300px;">
		@if($top_user)
		@foreach($top_user as $record)
		<div class="col-sm-3">
			<a href="#" title="" style="text-decoration: none;">
				@if (!empty($record->user->avatar))
				<img src="{{ $record->user->avatar }}" alt="Avatar" class="avatar" style="width: 80px;height:80px;border-radius: 50%;">
				@else
				<img src="{{ asset('picture/images.png') }}" alt="Avatar" class="avatar" style="width: 80px;height:80px;border-radius: 50%;">
				@endif
			</a>
		</div>
		@endforeach
		@endif
	</div>
</div>
@endsection