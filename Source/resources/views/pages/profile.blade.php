@extends('layouts.app')
<style type="text/css" media="screen">
	.user-avatar{
		border-radius: 50%;
		width: 150px;
		height:150px;

	}
	.form-control-label{
		text-align: left;
		margin-left: 20px;
	}
	@media only screen and (max-width: 400px) {
		.user-avatar{
			border-radius: 50%;
			width: 80px;
			height:80px;

		}
	}
</style>
@section('content')
<div class="container"  id="show_profile" style="margin-top: 100px; margin-bottom: 50px;display:flex;justify-content: center;">
	<div style="width: 800px;border-style: ridge;">
		<div style="display: flex;justify-content: center;margin-top: 10px;margin-bottom: 10px;">
			<img @if(!empty(Auth::user()->avatar)) src="{{Auth::user()->avatar}}" @else src="/picture/images.png" @endif alt="" class="user-avatar" style="">
		</div>
		<div class="row" style="justify-content: center;">
			<div class="col-9">
				<form class="form" role="form" autocomplete="off" style="margin-bottom: 30px;">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Name</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->name}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Email</label>
						<div class="col-sm-6">
							<input class="form-control" type="email" value="{{Auth::user()->email}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Birthday</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->birthday}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Addess</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->address}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Phone</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->phone}}" disabled>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 30px;">
						<div class="col">
							<a href="{{route('profile.edit')}}" title=""  id="edit"class="btn btn-info">Edit profiles</a>
							<a href="{{ url('/')}}" title=""  id="edit"class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection