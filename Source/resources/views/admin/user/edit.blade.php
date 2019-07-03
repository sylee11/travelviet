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
<form action="{{route('admin.user.edit1', $user->id)}}" method="post">
	{{csrf_field()}}
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required autocomplete="name">
  </div>
  <div class="form-group">
    <label for="inputEmail4">Email</label>
    <input id="email" type="email" name="email" value="{{ $user->email }}" class="form-control" disabled="">
  </div>

  <!-- <div class="form-group">
    <input type="checkbox" name="changePassword" id=changePasword >
    <label for="">Đổi mật khẩu</label>
    <input  type="password" name="password" value="" class="form-control password" disabled="" placeholder="Password">
  </div> -->
  

  <div class="form-group">
    <label for="">Phone</label>
    <input type="phone" name="phone" value="{{ $user->phone }}" class="form-control" required autocomplete="phone">
  </div>
  <div class="form-group">
    <label for="">Address</label>
    <input type="address" name="address" value="{{ $user->address }}" class="form-control" required autocomplete="address">
  </div>
  <div class="form-group">
    <label for="">Birthday</label>
    <input  type="date" name="birthday" value="{{ $user->birthday }}" required autocomplete="birthday">
  </div>
  <div class="form-group">
    <label for="">Satus</label>
    <label class="radio-inline">
      <input  name="status" value="0" @if($user->status == 0)
      {{"checked"}}
      @endif
      type="radio">Block
      <input type="radio" name="status" value="1" @if($user->status == 1)
      {{"checked"}}
      @endif>No Block
    </label>
  </div>
  <div class="form-group">
    <label for="">Avatar</label>
    <input  type="file" name="avatar" value="{{ $user->avatar }}" required autocomplete="file">
  </div>
  <div class="form-group">
    <label for="">Role</label>
    <label class="radio-inline">
      <input  name="role" value="1" @if($user->role == 1)
      {{"checked"}}
      @endif
      type="radio">Admin
      <input type="radio" name="role" value="2" @if($user->role == 2)
      {{"checked"}}
      @endif>Người đăng bài
      <input type="radio" name="role" value="3" @if($user->role == 3)
      {{"checked"}}
      @endif>Người xem
    </label>
  </div>
  <button type="submit" class="btn btn-primary">
    <i class="fa fa-btn fa-sign-in"></i>Update
  </button>
  <button type="submit" class="btn btn-danger">
    <a href="/admin/user" style="color: white">Cancel</a>
  </button>
</form>
@endsection

<!-- @section('script')
  <script>
    $(document).ready(function(){
         $("#changePasword").change(function(){
            if($(this).is(":checked"))
            {
              $(".password").removeAttr('disabled');
            }
            else{
              $(".password").attr('disabled','');
            }
         });
    });
  </script>
@endsection -->