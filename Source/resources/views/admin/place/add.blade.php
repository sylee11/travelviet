@extends('layouts.admin')
@section('content')
<h1>Thêm địa điểm</h1>
<form action="{{route('admin.place.add')}}" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token()}}">
	<div class="form-group">
		<label for="">Tên địa điểm </label>
		<input id="name" type="text" class="form-control" name="name" value=""    required autofocus >
	</div >
	<div class="form-group">
		<label for="">Address </label>
		<input id="address" type="text" class="form-control" name="address" value=""    required autofocus >
	</div>
	<div class="form-group col-md-2">
		<label for="">Category</label>
		<select class="custom-select" name="category_id">
			<option value="">Category</option>
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
				<option value="">City</option>
				@if($city)
				@foreach ($city as  $record)
				<option value="{{$record->id}}">{{$record->name}}</option>
				@endforeach
				@endif
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="">District</label>
			<select class="custom-select" name="districts_id" id="district">
				<option value="">District</option>
				<!-- @if($district)
				@foreach ($district as $record)
				<option value="{{$record->id}}">{{$record->name}}</option>
				@endforeach
				@endif -->
			</select>
		</div>

	</div>

	<button type="submit" class="btn btn-primary">Add</button>
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
