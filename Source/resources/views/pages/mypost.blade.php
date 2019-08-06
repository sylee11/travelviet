@extends('layouts.app')
@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@section('content')
<div class="container" style="margin-top: 100px;">
	@if (session('success'))
	<div class="alert alert-success">
		{{ session('success') }}
	</div>
	@endif
	@if (session('errro'))
	<div class="alert alert-danger">
		{{ session('errro') }}
	</div>
	@endif
	<h1 style="margin-top:150px;margin-bottom: 50px;">Những bài viết của tôi</h1>
	<a href="{{route('account.addpost', $id = Auth::id())}}" title="" class="btn btn-info" style="display: table;justify-content: left;margin-bottom: 50px;">Tạo mới</a>
	@foreach ($data as $key=>$value)
	<div class="row" style="margin-bottom: 50px;background-color: #f5f4ef;width: 100%;height:300px;justify-content: center;align-items: center;">
		<div class="col-sm-6">
			<img class="card-img-top" src="/{{$value->photo_path}}" alt="Card image cap" style="height: 280px;">
		</div>
		<div class="col-sm-6">
			<div class="text">
				<h5>{{$value->title}}</h5>
				<p class="created">Created: {{$value->created_at}}</p>
				<div>
					{!!Str::limit($value->describer, 100, ' ...')!!}
				</div>
				<a href="{{route('detail',$value->slug)}}" title="" class="btn btn-danger" style="border-radius: 50px;padding: 6px 20px;margin-top: 15px;margin-bottom: 15px;width: 145px;">Xem chi tiết</a>
				<p class="created">Trạng thái:
					@if($value->is_approved == 1)
					Đã phê duyệt
					@else
					Chưa phê duyệt
					@endif
				</p>
			</div>
			<div class="row" style="display: table;text-align: left;">
				<form>
					@csrf
					<a href="{{route('account.editpost', [$idPost = $value->post_id])}}" title="" class="btn btn-info" style="width: 75px;margin-right: 10px;">Edit</a>
					<button  formaction="{{route('mypost.delete', $id = $value->post_id)}}" title="" class="btn btn-danger " style="width: 75px;" onclick="return confirm('Bạn có muốn xoa bài đăng này?')" formmethod="post">Delete</button>
				</form>
			</div>
		</div>
	</div>
	@endforeach

</div>

<div style="display: inline-block;">{{$data->links()}}</div>

@endsection