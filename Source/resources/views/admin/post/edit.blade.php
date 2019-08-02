
@extends('layouts.admin')
@section('content')

<div class="container">
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
  @if (session('erro'))
    <div class="alert alert-danger">
        {{ session('erro') }}
    </div>
  @endif
  <FORM  method="post" class="" action="{{route('admin.post.edit', $post->id)}}" enctype="multipart/form-data">
    @csrf
    <div style="display: flex;">
      <div class="form-group">
        <label >Id:</label>
        <input type="number"  placeholder="{{$post->id}}" disabled="true" class="form-control" id="userid " name="id">

      </div>
      <div class="form-group " style="margin-left: 50px;" >
        <label >User id:</label>
        <select class="form-control" id="userid" name="userid" >
          <option > {{$post->user->name}}</option>
          @foreach($user as $u)
          <option value="{{ $u->id }}" @if (old("userid") == $u->id) {{'selected'}} @endif> {{ $u->name }}</option>

          @endforeach
        </select>
      </div>

      <div class="form-group"  style="margin-left: 50px";>
        <label >Place Id:</label>
        <select class="form-control" id="placeid" name="placeid">
          <option > {{$post->place->name}}</option>
          @foreach($place as $p)
          <option value ="{{ $p->id }}" @if (old('placeid') == $p->id) {{'selected'}} @endif>{{ $p->name }}</option>

          @endforeach
        </select>
      </div>

    </div>
    <div  class="form-group" style="display: flex;">
      <div class="form-group" >
        <label for="phone">Number phone:</label>
        <input type="" value="{{$post->phone}}"  class="form-control" id="number" name="phone">
      </div>
      <div class="form-group" style="margin-left: 50px;">
        <label >Is Approved(1 to post now)</label>
        <select class="form-control" id="approved" name="approved">
          <option > {{$post->is_approved}}</option>
          <option>0</option>
          <option>1</option>
        </select>
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
      <textarea class="form-control" rows="3" id="describer" name="describer" required>{!! $post->describer !!} </textarea>
    </div>

    {{-- show all photo --}}
    <div class="form-group">
     <input type="text" value="" style="display: none;"  class="form-control" id="p1" name="p1">
   </div>
   <h5>All photo</h5>
   <div class="form-group">
    <div  class="d-flex">

      @foreach($post->photos as $p)

      {{-- <img src="{{"/".$p->photo_path}}" alt="{{"/".$p->photo_path}}" style="width: 100px; height: 100px; background-repeat: no-repeat;"> --}}
      <div id="xxx" class="{{$p->id}}" style="display: flex; width: 150px; height: 150px; background-image: url({{"/".$p->photo_path}}); background-repeat: no-repeat; background-size: cover; margin-left: 10px;" >
       {{--  <a href="{{route('admin.post.deletephoto' , $p)}}"><img  src="/picture/front/close.png" style="width: 20px; height: 20px;" style="margin-left: 100px; " onclick="return confirm('Bạn có chắc muốn xóa ảnh này??')"></a> --}}
       <button class="{{$p->id}}" onclick="" type="button"  style="background-image:url('/picture/front/close.png'); width: 20px; height: 20px; " >

       </button>
       {{-- script hiden photo --}}
       <script type="text/javascript">
        $(".{{$p->id}}").click(function(){
          var xx =$(".{{$p->id}}");
          xx.hide();
          var t = document.getElementById("p1").value;
          console.log(t);
          document.getElementById("p1").value = t +  "{{$p->id}}/";

        })
      </script>
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
    {{--           <input type="file" name="filename[]" class="form-control">
    --}}          <div class="input-group-btn">  
      <button class="btn btn-success add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Click here to Add more</button>
    </div>
  </div>
  <div class="clone">
    <div class="control-group input-group" style="margin-top:10px">
      <input type="file" name="filename[]" class="form-control" accept="image/x-png,image/jpeg">
      <div class="input-group-btn"> 
        <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
      </div>

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

  var A = [];
  $(document).ready(function() {
    

    $(".add").click(function(){ 
      var html = $(".clone").html();
      $(".increment").after(html);
    });


     $("body").on("click",".btn-danger",function(){ 
          $(this).parents(".control-group").remove();
      });

    var ab=$(".clone");
    ab.hide();

      // $(".btnxx").click(function(){
      //     var xx =$("#xxx");
      //     xx.hide();
      // });
    CKEDITOR.replace('describer');
    });

  

  </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
  @endsection