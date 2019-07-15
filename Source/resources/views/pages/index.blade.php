@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('pages.home')
@section('content-section')
<div>
	<div class="container-fluid">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>Những địa điểm được đánh giá cao</h2></div>

		<div class="row">
			@if($top_rating->count() !== 0)
			@foreach ($top_rating as $record)
			<div class="col-sm-3" style="margin:50px 0;">
				<div class="card-img" style="height:280px;">
					<a href="#" title="" style="text-decoration: none;">
						<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="smaple image" style="height: 200px;">

						<div class="card-body">

							<h5 class="card-title">

								<span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap; font-size: 16px;color: #ff6f28;">
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
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>Những bài viết mới nhất</h2></div>

		<div class="row">
			@if($new_post->count() !== 0)
			@foreach ($new_post as $record)
			<div class="col-sm-3" style="margin:50px 0;">
				<div class="card-img" style="height:280px;">
					<a href="#" title="" style="text-decoration: none;">
						<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="smaple image" style="height: 200px;">

						<div class="card-body">

							<h5 class="card-title text-primary">

								<span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;font-size: 16px;color: #ff6f28;">
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
		@if($all_post->count() > 4)
		<div>
			<button type="button" class="btn btn-danger" id="all">Xem tất cả</button>
		</div>
		@endif
		@else
		<div class="col-sm">
			<p>Không có dữ liệu</p>
		</div>
		@endif
	</div>

	<div class="container-fluid" id="all_post" style="display: none;">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>Những bài viết mới nhất</h2></div>

		<div class="row">
			@if($all_post->count() !== 0)
			@foreach ($all_post as $record)
			<div class="col-sm-3" style="margin:50px 0;">
				<div class="card" style="height:280px;">
					<a href="#" title="" style="text-decoration: none;">
						<img class="card-img-top list_images" src="{{ $record->photo_path }}" alt="smaple image" style="height: 200px;">

						<div class="card-body">

							<h5 class="card-title text-primary">

								<span style="display:block;text-overflow: ellipsis;width: 200px;overflow: hidden; white-space: nowrap;font-size: 16px;color: #ff6f28;">
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
		@if($all_post->count() > 4)
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


	<div class="container-fluid">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;"><h2>Điểm đến nhiều nhất</h2></div>

		<div class="row">
			@foreach ($city as $element)
			<div class="col-sm-4" style="margin:50px 0;">
				<div class="card-img index" style="height:35 0px;">
					<a href="#" title="" style="text-decoration: none;">
						<img src="{{ $element->photo_path }}" alt="Avatar" class="card-img image">

						<div class="content">
							<h5>{{ $element->name }}</h5>
						</div>
						<div class="overlay">
						</div>
					</a>

				</div>
			</div>
			@endforeach

		</div>
	</div>


	<div class="container">
		<div style="text-align: center;margin-top:50px;color: #b3b3ba;margin-bottom: 50px;"><h2>Blog có số lượng bài viết nhiều nhất</h2></div>
		<div class="row" style="justify-content: center;">
			@if($top_user->count() !== 0)
			@foreach($top_user as $record)
			<div style="padding: 0 15px;">
				<a href="#" title="" style="text-decoration: none;">
					@if (!empty($record->user->avatar))
					<img src="{{ $record->user->avatar }}" alt="Avatar" class="avatar" title="{{!empty($record->user->name)?$record->user->name:'no name'}}" style="width: 80px;height:80px;border-radius: 50%;">

					@else
					<img src="{{ asset('picture/images.png') }}" alt="Avatar" class="avatar" title="{{!empty($record->user->name)?$record->user->name:'no name'}}" style="width: 80px;height:80px;border-radius: 50%;">
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
