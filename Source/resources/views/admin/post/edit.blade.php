@extends('layouts.admin')
@section('content')
<div class="container">
  <FORM  method="post" class="" action="{{route('admin.post.edit', $post->id)}}" enctype="multipart/form-data">
    @csrf
    <div style="display: flex;">
      <div class="form-group">
        <label >Id:</label>
        <input type="number"  placeholder="{{$post->id}}" disabled="true" class="form-control" id="userid " name="id">

      </div>
      <div class="form-group " style="margin-left: 50px;" >
        <label >User id:</label>
        <input type="number" value="{{$post->user_id}}"  class="form-control @error('userid') is-invalid @enderror" id="userid " name="userid">
      </div>

      <div class="form-group"  style="margin-left: 50px";>
        <label >Place Id:</label>
        <input type="number" value="{{$post->place_id}}"  class="form-control" id="userid " name="placeid">
      </div>

    </div>
    <div  class="form-group" style="display: flex;">
      <div class="form-group" >
        <label for="phone">Number phone:</label>
        <input type="" value="{{$post->phone}}"  class="form-control" id="number" name="phone">
      </div>
      <div class="form-group" style="margin-left: 50px;">
        <label >Is Approved(1 to post now)</label>
        <input type="number"  value="{{$post->is_approved}}" class="form-control" id="userid " name="approved">

      </div>
    </div>

    <div style="display: flex;">
      <div class="form-group" >
        <label for="phone">Create at:</label>
        <input type="" value="{{$post->created_at}}" disabled="true" class="form-control" id="number" name="number">
      </div>
      <div class="form-group" style="margin-left: 40px;">
        <label >Upadate at:</label>
        <input type="" value="{{$post->updated_at}}" disabled="true" class="form-control" id="userid " name="updated_at">
      </div>
    </div>
    <div class="form-group">
      <label for="">Title:</label>
      <input type="text" value="{{$post->title}}"  class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
      <label for="">Descrice:</label>
      <textarea class="form-control"  rows="5" id="describer" name="descricer">{{ $post->describer }} </textarea> 
    </div>

    {{-- show all photo --}}
    <h5>All photo</h5>
    <div class="form-group">
      <div  class="d-flex">

        @foreach($post->photos as $p)
        {{-- <img src="{{"/".$p->photo_path}}" alt="{{"/".$p->photo_path}}" style="width: 100px; height: 100px; background-repeat: no-repeat;"> --}}
        <div  class="" style="display: flex; width: 150px; height: 150px; background-image: url({{"/".$p->photo_path}}); background-repeat: no-repeat; background-size: cover; margin-left: 10px;">
          <a href="{{route('admin.post.deletephoto' , $p)}}"><img  src="/picture/front/close.png" style="width: 20px; height: 20px;" style="margin-left: 100px; " ></a>
        </div>
        @endforeach

      </div>

    </div>

    <div class="custom-file">
      {{--      <input type="file" class="custom-file-input" id="customFile" name="image" required="true">
      <label class="custom-file-label" for="customFile" >Choose file</label> --}}
      {{ csrf_field() }}
      {{--         <input type="file" name="filesTest" required="true" multiple data-show-upload="true">
      --}}
      <h5>Add more photo</h5>
      <div class="input-group control-group increment" >
        <input type="file" name="filename[]" class="form-control">
        <div class="input-group-btn">  
          <button class="btn btn-success add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Add</button>
        </div>
      </div>
      <div class=" clone hide" style="overflow: hidden;">
        <div class="control-group input-group" style="margin-top:10px">
          <input type="file" name="filename[]" class="form-control">
          <div class="input-group-btn"> 
            <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
          </div>
        </div>
      </div>


    </div> 


    <div class="flex-row ">
      <div class="justify-content-center flex-wrap "  style="margin: 20px;">
        <button class="btn-success" type="submit"  onclick="return confirm('Bạn có muốn sửa bản ghi này?')" > Save</button>
        <button class="btn-secondary" type="reset"> Cancel</button>
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