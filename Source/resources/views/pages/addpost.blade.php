<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
	<style type="text/css">
		.gallery img{
			margin-top: 20px;
			width: 200px;
			height: 200px;
			padding-right: 20px;
		}
	</style>
</head>

@extends('layouts.app')
	@section('content')
		<div class="container" style="margin-top: 200px; text-align: left;">
			<h3 class="text-center"> Add new Post</h3>
			<FORM   action="{{route('account.addpost', $id = Auth::id() )}}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="cate1" class="col-md-4 col-form-label"  > Category </label>
						<select class="custom-select" class="col-md-2" id="cete1" name="category">
							@foreach($category as $ca)
								<option> {{$ca->name}} </option>
							@endforeach
						</select>
					</div>	
					<div class="form-group col-md-6">
						<label  for="name" class="col-form-label"> Tên địa điểm </label>
						<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required="" >
							@error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
					</div>
				</div>

				<div class="form-row " >
					<div class="form-group col-md-6">
						<label  for="address" class="col-form-label col-md-4 "> Địa chỉ </label>
						<input type="text"  class="form-control col-md-8 @error('address') is-invalid @enderror" placeholder="Phường(Xã)-Quận(Huyện)-Tỉnh(ThànhPhố)" name="address" id="address" required="">
							@error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
					
					</div>
					<div class="form-group col-md-3">
						<label> Tỉnh, Thành Phố</label>
						<select  class="custom-select form-control" id="city" onchange="myFunction()" >
							<option>avc</option>
							@foreach($city as $ci)
								<option> {{$ci->name}}</option>
							@endforeach
							
						</select>

					</div>
					<div class="form-group col-md-3">
						<label>Quận, Huyện</label>

						<select class="custom-select form-control" name="districts_id" id="district">
						<option>District</option>						
						</select>
					</div>

				</div>
				<div class="form-group">
					<label class="col-form-label "> Số điện thoại </label>
					<input type="tel" class="form-control col-md-8 @error('phone') is-invalid @enderror "  placeholder="034567890" name="phone" id="phone">
						@error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-form-label @error('title') is-invalid @enderror"> Title bài đăng </label>
					<input type="text" class="form-control col-md-8" placeholder="" name="title" id="title" required="">
						@error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
				</div>
				<div class="form-group">
					<label for="textarea"> Mô tả chi tiết </label>
					<textarea name="descrice" class="form-control @error('descrice') is-invalid @enderror" rows="20" id="descrice" required=""> </textarea>
					{{-- <textarea class="form-control" rows="5" id="editor3" name="comment" required></textarea> --}}
						@error('descrice')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
				</div>


				{{-- <div class="custom-file"> 
					<div class="input-group control-group increment" >
						<img id="uploadPreview" style="width: 100px; height: 100px; display: none;"  />
			          	<input id="uploadImage" type="file" name="filename[]" class="form-control @error('filename') is-invalid @enderror" style="width: 100px; " onchange="PreviewImage()">
			          		@error('filename')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
			          	<div class="input-group-btn">  
			            	<button class="btn btn-success add" type="button"><i class="glyphicon glyphicon-plus" id="add"></i>Add More picture</button>
			          	</div>
			        </div>
			        <div class=" clone" style="overflow: hidden;">
			          	<div class="control-group input-group" style="margin-top:10px">
			          		<img id="uploadPreview" style="width: 100px; height: 100px; display: none;"  />
			            	<input id=" uploadImage" type="file" multiple="" name="filename[]" class="form-control" onchange="PreviewImage()">
			            	<div class="input-group-btn"> 
			             		<button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove" id="removed"></i> Remove</button>
			            	</div>
			          	</div>
			        </div>
				</div> --}}

{{-- 				<form action="/" method="post" class="dropzone" id="my-awesome-dropzone" enctype="multipart/form-data">

				</form> --}}
				<h5 class="form-control-label"> Thêm ảnh cho bài viết</h5>
				<div class="form-control-file">
					<input multiple type="file"  id="gallery-photo-add" class="form-control" name="filename[]" required="">

								<div class="gallery" style="display: flex; width: 200px;height: 200px;">
								</div>	
				</div>				

				<div style=" margin-top: 100px; margin-bottom: 50px;">
					<button type="submit" class="btn btn-primary" style="width: 100px;">Đăng bài</button>
					<button type="reset" class="btn btn-dark" style="width: 100px;"> Reset</button>


				</div>
			</FORM>

{{-- 			<form action="/" method="post" class="dropzone" id="my-awesome-dropzone">
				
			</form> --}} 


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
   $("img").click(function(){
   		$("img").hide();

   })

$(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {

        if (input.files) {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#gallery-photo-add').on('change', function() {
        imagesPreview(this, 'div.gallery');
    });
});

    function myFunction(){
    var cityID = document.getElementById("city").value; 
    console.log(cityID);   
    if(cityID){
    	$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});
        $.ajax({
           type:"GET",
           url:"{{route('acount.post.getcity')}}?cities_id="+cityID,
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
   };
	
   // $('#city').change(function(){
			// 			    var cityID = $(this).val();   
			// 			    console.log(cityID) ;
			// 			    if(cityID){
			// 			        $.ajax({
			// 			           type:"GET",
			// 			           url:"{{route('admin.place.getcity')}}?cities_id="+cityID,
			// 			           success:function(res){               
			// 			            if(res){
			// 			                $("#district").empty();
			// 			                $("#district").append('<option>District</option>');
			// 			                $.each(res,function(key,value){
			// 			                    $("#district").append('<option value="'+key+'">'+value+'</option>');
			// 			                });
			// 			            }else{
			// 			               $("#district").empty();
			// 			            }
			// 			           }
			// 			        });
			// 			    }else
			// 			    {
			// 			        $("#district").empty();    
			// 			    }      
			// 			   });
</script>

{{-- @push('scripts')
	<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
	<script> CKEDITOR.replace('editor3'); </script>
@endpush --}}
@endsection



