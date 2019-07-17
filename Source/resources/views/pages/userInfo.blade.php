@extends('layouts.app')

@section('content')
<!-- ///////////add profile///////////// -->

<div class="container"  id="show_profile" style="margin-top: 150px; margin-bottom: 50px;">
	<img @if(!empty($data->avatar)) src="/{{$data->avatar}}" @else src="/picture/images.png" @endif alt="" class="user-avatar" style="border-radius: 50%;width: 200px;">
	<hr>
	
	<form class="form" role="form" autocomplete="off" style="margin-top: 30px;">
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Name</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{$data->name}}"  disabled>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Email</label>
			<div class="col-lg-6">
				<input class="form-control" type="email" value="{{$data->email}}"  disabled>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Birthday</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{$data->birthday}}"  disabled>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Addess</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{$data->address}}"  disabled>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Phone</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{$data->phone}}" disabled>
			</div>
		</div>
	</form>
    <a href="{{$data->id}}/post" id="" class="btn btn-primary">Find all post</a>
    <a href="{{$data->id}}/comment" id="" class="btn btn-primary">Find all comment</a>
	<a href="{{ URL::previous()}}" title=""  id="edit"class="btn btn-danger">Cancel</a>
	<!-- <a href="{{ url('/')}}" title=""  id="edit"class="btn btn-danger">Cancel</a> -->
</div>

@endsection