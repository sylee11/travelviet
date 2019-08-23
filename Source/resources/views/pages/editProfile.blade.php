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
<!-- ///////////edit profile///////////// -->
<div class="container"  id="show_profile" style="margin-top: 100px; margin-bottom: 50px;display:flex;justify-content: center;">
	<div style="width: 800px;border-style: ridge;">
		<div style="display: flex;justify-content: center;margin-top: 10px;margin-bottom: 10px;">
			<form action="{{route('avatar.update')}}" method="post" enctype="multipart/form-data" id="hh">
				{{csrf_field()}}
				<div class="image-upload">
					<label for="file-input">
						<img @if(!empty(Auth::user()->avatar)) src="{{Auth::user()->avatar}}" @else src="/picture/images.png" @endif alt="avatar" class="user-avatar" id="avatar">
					</label>

					<input id="file-input" type="file"  name="avatar" style="display: none;" {{-- onchange="readURL(this);" --}} />
				</div>
				<button  class="btn-sm btn btn-primary" id="change_avatar">Update</button>

			</form>
		</div>
		<div class="row" style="justify-content: center;">
			
			<div class="col-9">
				<form class="form" role="form" autocomplete="off"  style=" margin-bottom: 50px;" action="{{route('profile.update')}}" method="POST">

					{{csrf_field()}}
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Name</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->name}}" name ="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Email</label>
						<div class="col-sm-6">
							<input class="form-control" type="email" value="{{Auth::user()->email}}" name ="email" disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Birthday</label>
						<div class="col-sm-6">
							<input class="form-control" type="date" value="{{Auth::user()->birthday}}" id="example-date-input" name ="birthday">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Addess</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->address}}" name ="address">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label form-control-label">Phone</label>
						<div class="col-sm-6">
							<input class="form-control" type="text" value="{{Auth::user()->phone}}" name ="phone">
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 30px;">
						<div class="col">
							<button class="btn btn-info" >Update</button>
							<a href="{{ url('profile') }}" title=""  id="edit_button"class="btn btn-info">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#avatar')
					.attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#file-input").change(function() {
			readURL(this);
		});

	});
</script>
@endsection