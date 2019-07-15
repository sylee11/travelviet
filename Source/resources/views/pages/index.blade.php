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
							@for($i=0;$i< ceil($record->avg_rating);$i++)
							<span class="fa fa-star checked" ></span>
							@endfor
							@for($i=ceil($record->avg_rating);$i< 5;$i++)
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

<div class="container" id="new_post">
	<div style="text-align: left;margin:50px 0;"><h2>New posts</h2></div>
	<div class="row">
		@if($new_post)
		@foreach ($new_post as $record)
		<div class="col-sm-4" style="margin:50px 0;">
			<div class="card" style="width: 20rem;height:350px;">
				<a href="/detail/{{$record->id}}" title="" style="text-decoration: none;">
					<img class="card-img-top list_images" src="{{ asset('picture/front/image2.jpg') }}" alt="smaple image">

					<div class="card-body">

						<h5 class="card-title text-primary">{{$record->title}}</h5>
						<div class="rating">
							@for($i=0;$i< $record->avg_rating;$i++)
							<span class="fa fa-star checked" ></span>
							@endfor
							@for($i=$record->avg_rating;$i< 5;$i++)
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
		@endif
	</div>
	<div>
		<button type="button" class="btn btn-info" id="all">Xem tất cả</button>
	</div>

</div>
<div class="container" style="display: none;"  id="all_post">
	<div style="text-align: left;margin:50px 0;"><h2>New posts</h2></div>
	<div class="row">
		@if($all_post)
		@foreach ($all_post as $record)
		<div class="col-sm-4" style="margin:50px 0;">
			<div class="card" style="width: 20rem;height:350px;">
				<a href="#" title="" style="text-decoration: none;">
					<img class="card-img-top list_images" src="{{ asset('picture/front/image2.jpg') }}" alt="smaple image">

					<div class="card-body">

						<h5 class="card-title text-primary">{{$record->title}}</h5>
						<div class="rating">
							@for($i=0;$i< $record->avg_rating;$i++)
							<span class="fa fa-star checked" ></span>
							@endfor
							@for($i=$record->avg_rating;$i< 5;$i++)
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
		@endif
	</div>
	<div>
		<button type="button" class="btn btn-info" id="new">Thu gọn</button>
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
				<img src="{{ $record->user->avatar }}" alt="Avatar" class="avatar" title="{{!empty($record->user->name)?$record->user->name:'no name'}}" style="width: 80px;height:80px;border-radius: 50%;">

				@else
				<img src="{{ asset('picture/images.png') }}" alt="Avatar" class="avatar" title="{{!empty($record->user->name)?$record->user->name:'no name'}}" style="width: 80px;height:80px;border-radius: 50%;">
				@endif
			</a>
		</div>
		@endforeach
		@endif
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
</script>
@endsection
