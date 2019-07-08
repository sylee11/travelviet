@extends('layouts.admin')
@section('content')
<h1>Chỉnh sửa User</h1>
<!-- @if (session('thongbao'))
 <div class="alert alert-danger">
 	{{session('thongbao')}}
 </div>
@endif -->

@if(count($errors)>0)
<div class="alert alert-danger">
  @foreach($errors->all() as $err)
  {{$err}} <br>
  @endforeach
</div>
@endif
@if(Session::has('message'))
<div class="alert alert-danger">
	{{Session::get('message')}}
</div>
@endif
<form action="{{route('admin.place.edit', $place->id)}}" method="post">
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
  <div class="form-group col-md-2">
    <label for="">Category</label>
    <select class="custom-select" name="category_id">
      <option value="{{$place->category_id}}">{{$place->category->name}}</option>
      @if($category)
      @foreach ($category as $ca)
      <option value="{{$ca->id}}">{{$ca->name}}</option>
      @endforeach
      @endif
    </select>
  </div>
  <div class="form-row">
    <div class="form-group col-md-3">
      <label for="">City</label>
      <select class="custom-select" name="" id="city">
        <option value="{{$place->districts_id}}">{{$place->districts->cities->name}}</option>
        @if($city)
        @foreach ($city as $ci)
        <option value="{{$ci->id}}">{{$ci->name}}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="">District</label>
      <select class="custom-select" name="districts_id" id="district">
        <option value="{{$place->districts_id}}">{{$place->districts->name}}</option>
        @if($district)
        @foreach ($district as $record)
        <option value="{{$record->id}}">{{$record->name}}</option>
        @endforeach
        @endif
      </select>
    </div>

  </div>
  <button type="submit" class="btn btn-primary">
    <i class="fa fa-btn fa-sign-in"></i>Update
  </button>
  <button type="submit" class="btn btn-danger">
    <a href="/admin/place" style="color: white">Cancel</a>
  </button>
</form>
<script type="text/javascript">
    $('#city').change(function(){
    var cityID = $(this).val();    
    if(cityID){
        $.ajax({
           type:"GET",
           url:"{{route('admin.place.getcity')}}?cities_id="+cityID,
           success:function(res){               
            if(res){
                $("#district").empty();
                $("#district").append('<option>District</option>');
                $.each(res,function(key,value){
                    $("#district").append('<option value="'+key+'">'+value+'</option>');
                });
            }else{
               $("#district").empty();
            }
           }
        });
    }else
    {
        $("#district").empty();    
    }      
   });
    
</script>
@endsection
