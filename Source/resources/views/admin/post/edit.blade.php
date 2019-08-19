
@extends('layouts.admin')
@section('content')

<div class="container">
  @if(count($errors)>0)
   <div class="alert alert-danger">
    @foreach($errors->all() as $err)
    {{$err}} <br>
    @endforeach
    </div>
  @endif
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
  @endif
  <FORM  method="post" class="" action="{{route('admin.post.edit', $post->id)}}" enctype="multipart/form-data">
    @csrf
    <div style="display: flex;">
      <div class="form-group">
        <label >Id:</label>
        <input type="number"  placeholder="{{$post->id}}" disabled="true" class="form-control" id="postid " name="id">

      </div>
      <div class="form-group " style="margin-left: 50px;" >
        <label >User :</label>
        {{-- <select class="form-control" id="userid" name="userid" >
          <option > {{$post->user->name}}</option>
          @foreach($user as $u)
          <option value="{{ $u->id }}" @if (old("userid") == $u->id) {{'selected'}} @endif> {{ $u->name }}</option>

          @endforeach
        </select> --}}
        <input class="form-control" type="text" name="userid" id="userid" value="{{old('userid', $post->user->name)}}" required="">
        <div id="errouser" style="display: none;"> <span style="color: red"> Không tồn tại user </span></div>
      </div>

      <div class="form-group"  style="margin-left: 50px";>
        <label >Place :</label>
        <input class="form-control" type="text" name="placeid" id="placeid" value="{{old('placeid', $post->place->name)}}" required="">
        <div id="erroplace" style="display: none;"> <span style="color: red"> Không tồn tại place </span></div>
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
      <textarea class="form-control" rows="3" id="describer" name="describer" >{!! $post->describer !!} </textarea>
    </div>

    {{-- show all photo --}}
    <div class="form-group">
     <input type="text" value="" style="display: none;"  class="form-control" id="p1" name="p1">
   </div>
   <h5>All photo</h5>
   <div class="form-group">
    <div  class="d-flex">

      @foreach($post->photos as $p)

      <div id="xxx" class="{{$p->id}}" style="display: flex; width: 150px; height: 150px; background-image: url({{"/".$p->photo_path}}); background-repeat: no-repeat; background-size: cover; margin-left: 10px;" >
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
  {{ csrf_field() }}
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
    <button class="btn-success" type="submit"  onclick="return confirm('Bạn có muốn sửa bản ghi này?')"  id="submit"> Save</button>
    <button class="btn-secondary" type="reset"> Cancel</button>
  </div>
</div>


</FORM>

{{-- script add muti image --}}
</div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

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


    $("#submit").on('click',function(){
        if($("#errouser").css('display') == 'block' || $("#erroplace").css('display') == 'block'){
            alert("Erros! Vui lòng kiểm tra lại thông tin");
            return false;
          }
    }) 
    CKEDITOR.replace('describer');
    });


    $('#userid').typeahead({
        source:  function (term, process) {
        return $.get("{{ route('post.autocompleteUser')}}", { term: term }, function (data) {
            if(data.length == 0){
              $('#errouser').css('display', 'block');
            }
            else{
              $('#errouser').css('display','none');
            }
                return process(data);
            });
        }
    });

    $('#placeid').typeahead({
        source:  function (term, process) {
        return $.get("{{ route('post.autocompletePlace')}}", { term: term }, function (data) {
            if(data.length == 0){
              $('#erroplace').css('display', 'block');
            }
            else{
              $('#erroplace').css('display','none');
            }
                return process(data);
            });
        }
    });
  

  </script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
  @endsection