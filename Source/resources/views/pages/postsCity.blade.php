@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
	<h1 style="margin-top:150px;margin-bottom: 50px;">Một số địa điểm tại {{$name_city->name}}</h1>
	@foreach ($post_city as $key=>$value)
	<div class="row" style="margin-bottom: 50px;background-color: #f5f4ef;width: 100%;height:300px;justify-content: center;
	align-items: center;">
	<div class="col-sm-6">
		<img class="card-img-top" src="/{{$value->photo_path}}" alt="{{$value->title}}" style="height: 280px;">
	</div>
	<div class="col-sm-6">
		<div class="text">
			<h5>{{$value->title}}</h5>
			<p class="created">Created: {{$value->created_at}}</p>
			@if(!empty($value->name))
			<p class="created">By: {{$value->name}}</p>
			@endif
			<span class="text-descript">
				<p >{{$value->describer}}</p>
			</span>
			<a href="{{route('detail',$value->post_id)}}" title="" class="btn btn-danger" style="border-radius: 50px;padding: 6px 20px;margin-top: 15px;">Xem chi tiết</a>
		</div>
	</div>
</div>
@endforeach
</div>
<div style="display: inline-block;">{{$post_city->links()}}</div>
@endsection