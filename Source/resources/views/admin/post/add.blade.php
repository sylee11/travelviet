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

  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
	<FORM method="post" class="" action="{{route('admin.post.add')}}" enctype="multipart/form-data">
	@csrf

	<div style="display: flex;">
		<div class="form-group">
	    	<label >User :</label>
	    	@error('userid')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
        <input class="form-control" type="text" name="userid" id="userid" value="{{old('userid')}}" required="">
        <div id="errouser" style="display: none;"> <span style="color: red"> Không tồn tại user </span></div>
	  	</div>
		<div class="form-group" style="margin-left: 40px;">
	    	<label for="">Phone number:</label>
	    	<input type="tel" class="form-control" id="number" name="number" required="" value="{{ old('number')}}">
	  	</div>
	</div>
	<div class="form-group">
    	<label for="">Place :</label>
      <input class="form-control" type="text" name="placeid" id="placeid" value="{{old('placeid')}}" required="">
      <div id="erroplace" style="display: none;"> <span style="color: red"> Không tồn tại địa điểm này </span>
      </div>
  </div>
	<div class="form-group">
    	<label for="">Title:</label>
    	<input type="text" class="form-control" id="title" name="title" required="" value="{{old('title')}}">
  	</div>
	<div class="form-group">
    	<label for="">Descrice:</label>
      <textarea class="form-control" rows="3" id="describer" name="describer" required>{{old('describer')}}</textarea>
  	</div>
	<div class="form-group form-check" style="display: flex;">
     	<input class="form-check-input" type="checkbox" name="checkbox" value="1">Post now:
  	</div>
  	<div class="custom-file" style="height: auto;">

 		<h5>Upload image</h5>
        <div class="input-group control-group increment" >
          <input type="file" name="filename[]" class="form-control" accept="image/x-png,image/jpeg" required="" accept="image|jpeg|x-png">
          <div class="input-group-btn">  
            <button class="btn btn-primary add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Add</button>
          </div>
        </div>
        <div class=" clone" style="overflow: hidden;">
          <div class="control-group input-group" style="margin-top:10px">
            <input type="file" name="filename[]" class="form-control" accept="image/x-png,image/jpeg">
            <div class="input-group-btn"> 
              <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
            </div>
          </div>
        </div>


  	</div> 
  	<div class="">
      <div class="text-center" style="margin-top: 20px;">
  		  <button class="btn btn-success align-middle" type="submit" id="submit"> Xác nhận thêm</button>
      </div>
  	</div>
	</FORM>

{{-- script add muti image --}}
</div>
    {{-- include typeahead --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
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

      CKEDITOR.replace('describer');

      $("#submit").on('click',function(){
        if($("#errouser").css('display') == 'block' || $("#erroplace").css('display') == 'block'){
            alert("Erros! Vui lòng kiểm tra lại thông tin");
            return false;
          }
      }) 

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