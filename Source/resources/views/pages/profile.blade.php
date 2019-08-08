@extends('layouts.app')

@section('content')
<!-- ///////////add profile///////////// -->
<div class="container"  id="show_profile" style="margin-top: 100px; margin-bottom: 50px;display:flex;justify-content: center;">
	<div style="width: 800px;">
		<div class="row" style="border-style: ridge;">
			<div class="col-3" style="display: flex;align-items: center;">
				<img @if(!empty(Auth::user()->avatar)) src="{{Auth::user()->avatar}}" @else src="/picture/images.png" @endif alt="" class="user-avatar" style="border-radius: 50%;width: 200px;height:200px;">
			</div>
			<div class="col-9">
				<form class="form" role="form" autocomplete="off" style="padding: 50px 0px;margin-bottom: 30px;">
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Name</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" value="{{Auth::user()->name}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Email</label>
						<div class="col-lg-6">
							<input class="form-control" type="email" value="{{Auth::user()->email}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Birthday</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" value="{{Auth::user()->birthday}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Addess</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" value="{{Auth::user()->address}}"  disabled>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-lg-3 col-form-label form-control-label">Phone</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" value="{{Auth::user()->phone}}" disabled>
						</div>
					</div>
				</form>
				<div style="margin-bottom: 30px;">
					<a href="{{route('profile.edit')}}" title=""  id="edit"class="btn btn-info">Edit profiles</a>
					<a href="{{ url('/')}}" title=""  id="edit"class="btn btn-danger">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection