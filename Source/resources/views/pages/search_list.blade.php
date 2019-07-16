@extends('layouts.app')

@section('content')
<div style="padding-top: 50px;">Danh sách kết quả tìm kiếm </div>
<div class="row">

	@foreach ($post as $record)

	<div class="col-sm-4" style="margin:50px 0;">
		<div class="card" style="width: 20rem;height:350px;">
			<a href="#" title="" style="text-decoration: none;">
				<img class="card-img-top list_images"  alt="smaple image">
				<div class="card-body">
					<h5 class="card-title text-primary">{{$record->title}}</h5>
					<div class="rating">
						<span class="fa fa-star checked" ></span>
						<span class="fa fa-star" ></span>
					</div>
					
					<p class="card-text">
					</p>
				</div>
			</a>
		</div>
	</div>
	@endforeach

</div>
<div>
	<button type="button" class="btn btn-info" id="all">Xem tất cả</button>
</div>

@endsection