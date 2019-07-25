@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('layouts.app')
@section('content')

<div class="container-fluid">
	<div style="text-align: center;margin-top:100px;color: black;margin-bottom: 50px;"><h2>Tất cả các bài viết</h2></div>
	<form class="form-inline" style="margin-bottom: 50px;justify-content: center;" method="get" action="{{route('search.posts')}}">
		<input type="text" class="form-control" name="search" 
		value="" placeholder="Nhập từ khóa" style="width: 300px;">
		<button type="submit" class="btn-success btn" style="margin-left: 20px;"> Search</button>
	</form>
	@if(isset($search))
	<div class="font-weight-bold">
		Đã tìm thấy <span style="color: green;">{{$all_posts->count()}}</span> kết quả  cho từ khóa <span style="color: green"> "{{$search}}"</span>
	</div>
	@endif

	<div class="row" style="justify-content: center;">



		@if($all_posts->count() !== 0)
		@foreach ($all_posts as $record)
		<div class="col-sm-4" style="margin:50px 0;">
			<div class="card-img" id="card-img" >
				<a href="{{route('detail',$record->id)}}" title="" style="text-decoration: none;"id="pic">
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
	@else
	<div class="col-sm">
		<p>Không có dữ liệu</p>
	</div>
	@endif
</div>
<div style="display: inline-block;">{{$all_posts->links()}}</div>
@endsection