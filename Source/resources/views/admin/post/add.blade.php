
<head>
{{--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
 --}}
</head>
<div class="container">
    @if(count($errors) >0)
      <div class="alert alert-danger">
        @foreach($errors->all() as $error)
          <li> {{$error}} </li>

        @endforeach
      </div>
      <script>
        $(document).ready(function(){
            $('#myModal3').modal('show')
        }
      </script>
    @endif
    @if(Session::has('errors'))
<script>
$(document).ready(function(){
    $('#myModal3').modal({show: true});
}
</script>
@endif
	<FORM method="post" class="" action="{{route('admin.post.add')}}" enctype="multipart/form-data">
	@csrf
{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
	<div style="display: flex;">
		<div class="form-group">
	    	<label >User id:</label>
	    {{-- 	<input type="number" class="form-control @error('userid') is-invalid @enderror" id="userid " name="userid"> --}}
	    	@error('userid')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
        <select class="form-control" id="userid" name="userid">
          @foreach($user as $u)
            <option>{{ $u->id }}</option>

          @endforeach
        </select>
	  	</div>
		<div class="form-group" style="margin-left: 40px;">
	    	<label for="">Phone number:</label>
	    	<input type="tel" class="form-control" id="number" name="number">
	  	</div>
	</div>
	<div class="form-group">
    	<label for="">Place id:</label>
       <select class="form-control" id="placeid" name="placeid">
          @foreach($place as $p)
            <option>{{ $p->id }}</option>

          @endforeach
      </select>
  </div>
	<div class="form-group">
    	<label for="">Title:</label>
    	<input type="text" class="form-control" id="title" name="title">
  	</div>
	<div class="form-group">
    	<label for="">Descrice:</label>
  		<textarea class="form-control" rows="5" id="describer" name="describer"></textarea> 
  	</div>
	<div class="form-group form-check" style="display: flex;">
     	<input class="form-check-input" type="checkbox" name="checkbox" value="1">Post now:
    </label>
  	</div>
  	<div class="custom-file">
{{--     	<input type="file" class="custom-file-input" id="customFile" name="image" required="true">
    	<label class="custom-file-label" for="customFile" >Choose file</label> --}}
    	 {{ csrf_field() }}
{{--         <input type="file" name="filesTest" required="true" multiple data-show-upload="true">
 --}}
 		<h5>Upload image</h5>
        <div class="input-group control-group increment" >
          <input type="file" name="filename[]" class="form-control">
          <div class="input-group-btn">  
            <button class="btn btn-success add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Add</button>
          </div>
        </div>
        <div class=" clone" style="overflow: hidden;">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="filename[]" class="form-control">
            <div class="input-group-btn"> 
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
            </div>
          </div>
        </div>


  	</div> 
  	<div>
  		<button class="btn-success" type="submit"> Add</button>
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

      var ab=$(".clone");
      ab.hide();

    });

</script>