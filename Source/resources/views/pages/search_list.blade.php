@extends('layouts.app')
@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" style="margin-top: 50px;">
	<h1 style="margin-top:100px;margin-bottom: 50px;">Danh sách kết quả tìm kiếm </h1>
	
	@foreach ($post as $record)
	<div class="row" style="margin-bottom: 50px;background-color: #f5f4ef;width: 100%;height:300px;justify-content: center;
	align-items: center;">
	<div class="col-sm-6">
		<img class="card-img-top" src="{{$record->photo_path}}" alt="{{$record->title}}" style="height: 280px;">
	</div>
	<div class="col-sm-6">
		<div class="text">
			<h5 class="card-title text-primary">{{$record->title}}</h5>
		
			<div class="rating">
				@for($i=0;$i< ceil($record->avg_rating);$i++)
				<span class="fa fa-star checked"></span>
				@endfor
				@for($i=ceil($record->avg_rating);$i< 5;$i++)
				<span class="fa fa-star unchecked"></span>
				@endfor
			</div>
			
			<a href="/detail/{{$record->id}}" title="" class="btn btn-danger" style="border-radius: 50px;padding: 6px 20px;margin-top: 15px;margin-bottom: 15px;">Xem chi tiết</a>
			
		</div>
		
	</div>
</div>
@endforeach

</div>

@endsection
