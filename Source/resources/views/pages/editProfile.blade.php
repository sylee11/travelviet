@extends('layouts.app')

@section('content')
<!-- ///////////edit profile///////////// -->
<div class="container"  id="edit_profile" style="margin-top: 150px;">
	<form action="{{route('avatar.update')}}" method="post" enctype="multipart/form-data" id="hh">
		{{csrf_field()}}
		<div class="image-upload">
			<label for="file-input">
				<img @if(!empty(Auth::user()->avatar)) src="{{Auth::user()->avatar}}" @else src="/picture/images.png" @endif alt="" class="user-avatar" id="avatar" style="border-radius: 50%;width: 100px;height: 100px;">
			</label>

			<input id="file-input" type="file"  name="avatar" style="display: none;" {{-- onchange="readURL(this);" --}} />
		</div>
		<button  class="btn-sm btn btn-primary" id="change_avatar">Update avatar</button>

	</form>

	<hr>
	<form class="form" role="form" autocomplete="off"  style="margin-top: 30px; margin-bottom: 50px;" action="{{route('profile.update')}}" method="POST">

		{{csrf_field()}}
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Name</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{Auth::user()->name}}" name ="name">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Email</label>
			<div class="col-lg-6">
				<input class="form-control" type="email" value="{{Auth::user()->email}}" name ="email">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Birthday</label>
			<div class="col-lg-6">
				<input class="form-control" type="date" value="{{Auth::user()->birthday}}" id="example-date-input" name ="birthday">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Addess</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{Auth::user()->address}}" name ="address">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label form-control-label">Phone</label>
			<div class="col-lg-6">
				<input class="form-control" type="text" value="{{Auth::user()->phone}}" name ="phone">
			</div>
		</div>
		<button class="btn btn-info" >Update</button>
		<a href="{{ url('profile') }}" title=""  id="edit_button"class="btn btn-info">Cancel</a>
	</form>
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