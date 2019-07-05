@extends('layouts.admin')
@section('content')
<div class="container">
	<FORM >
	@csrf
	<div style="display: flex;">
		<div class="form-group">
	    	<label >Id:</label>
	    	<input type="number"  value="{{$post->id}}" disabled="true" class="form-control" id="userid " name="userid">

	  	</div>
		<div class="form-group " style="margin-left: 50px;" >
	    	<label >User id:</label>
	    	<input type="number" value="{{$post->user_id}}" disabled="true" class="form-control @error('userid') is-invalid @enderror" id="userid " name="userid">
	  	</div>

	  	<div class="form-group"  style="margin-left: 50px";>
	    	<label >Place Id:</label>
	    	<input type="number" value="{{$post->place_id}}" disabled="true" class="form-control" id="userid " name="userid">
	  	</div>

	</div>
	<div  class="form-group" style="display: flex;">
    	<div class="form-group" >
	    	<label for="phone">Number phone:</label>
	    	<input type="" value="{{$post->phone}}" disabled="true" class="form-control" id="number" name="number">
	  	</div>
	  	<div class="form-group" style="margin-left: 50px;">
	    	<label >Is Approved:</label>
	    	<input type="number" value="{{$post->is_approved}}" disabled="true" class="form-control" id="userid " name="userid">
	  	</div>
  	</div>

  	<div style="display: flex;">
    	<div class="form-group" >
	    	<label for="phone">Create at:</label>
	    	<input type="" value="{{$post->created_at}}" disabled="true" class="form-control" id="number" name="number">
	  	</div>
	  	<div class="form-group" style="margin-left: 40px;">
	    	<label >Upadate at:</label>
	    	<input type="" value="{{$post->updated_at}}" disabled="true" class="form-control" id="userid " name="">
	  	</div>
  	</div>
	<div class="form-group">
    	<label for="">Title:</label>
    	<input type="text" value="{{$post->title}}" disabled="true" class="form-control" id="title" name="title">
  	</div>
	<div class="form-group">
    	<label for="">Descrice:</label>
  		<textarea class="form-control" disabled="true" rows="5" id="descrice" name="descrice">{{ $post->describer }} </textarea> 
  	</div>

    {{-- show all photo --}}
   	<h5>All photo</h5>
    <div class="form-group">
    	<div >

    		@foreach($post->photos as $p)
    		{{-- <img src="{{"/".$post->photos[1]->photo_path}}" alt="{{$post->photos[0]->photo_path}}" style="width: 100px; height: 100px; background-repeat: no-repeat;"> --}}
    		<img src="{{"/".$p->photo_path}}" alt="{{"/".$p->photo_path}}" style="width: 100px; height: 100px; background-repeat: no-repeat;">
    		@endforeach

    	</div>

    </div>

  	<div class="flex-row ">
  		<div class="justify-content-center flex-wrap">
  			<a href="{{route('admin.post.showedit',$post->id)}}" type="button" class="btn btn-primary list-inline"> Edit</a>
  			<a href="{{ route('admin.post.delete', $post->id)}}" class="btn-danger btn" role='button' onclick="return confirm('Bạn có muốn xóa bản ghi này?')"> Delete</a>
  		</div>

  	</div>
	</FORM>

{{-- script add muti image --}}
</div>
<script type="text/javascript">

    $(document).ready(function() {

      $(".add").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    });

</script>
@endsection