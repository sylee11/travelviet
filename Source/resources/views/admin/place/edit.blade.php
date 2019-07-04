@extends('layouts.admin')
@section('content')
<h1>Chỉnh sửa User</h1>
<!-- @if (session('thongbao'))
 <div class="alert alert-danger">
 	{{session('thongbao')}}
 </div>
@endif -->
@if(Session::has('message'))
<div class="alert alert-danger">
	{{Session::get('message')}}
</div>
@endif
<form action="{{route('admin.place.edit1', $place->id)}}" method="post">
	{{csrf_field()}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $place->name }}" class="form-control" required autocomplete="name">
  </div>
  <div class="form-group">
    <label for="">Address</label>
    <input id="text" type="text" name="address" value="{{ $place->address }}" class="form-control" required autocomplete="address">
  </div>
  
  <button type="submit" class="btn btn-primary">
    <i class="fa fa-btn fa-sign-in"></i>Update
  </button>
  <button type="submit" class="btn btn-danger">
    <a href="/admin/place" style="color: white">Cancel</a>
  </button>
</form>
@endsection
