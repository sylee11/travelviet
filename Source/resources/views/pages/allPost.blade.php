@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('layouts.app')
@section('content')

<div class="container-fluid">
	<div style="text-align: center;margin-top:100px;color: black;"><h2>Tất cả các bài viết</h2></div>

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