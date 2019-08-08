<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
	<style type="text/css">
		.gallery img{
			margin-top: 20px;
			width: 150px;
			height: 150px;
			padding-right: 20px;
		}
	</style>
</head>

@extends('layouts.app')
	@section('content')
		<div class="container" style="margin-top: 100px; text-align: left;">
			<h3 class="text-center"> Edit Post</h3>
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
			<FORM   action="{{route('account.editpost', [$idpost=$post->id] )}}" method="post" enctype="multipart/form-data" id="formedit">
				@csrf
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="cate1" class="col-md-4 col-form-label"  > Category </label>
						<select  class="custom-select form-control" id="cate1" onchange="" name="category"  >
							<option> {{$post->place->category->name}}</option>
							@foreach($category as $ca)
								<option> {{$ca->name}}</option>
							@endforeach
							
						</select>
					</div>	
					<div class="form-group col-md-6">
						<label  for="name" class="col-form-label"> Tên địa điểm </label>
						<input type="text" readonly="" class="form-control"  value = "{{$post->place->name}}" name="name" id="name"  >

					</div>
				</div>

				<div class="form-row " >
					<div class="form-group col-md-12">
						<label  for="address" class="col-form-label col-md-4 "> Địa chỉ cụ thể</label>
						<input type="text"  class="form-control col-md-8 @error('address') is-invalid @enderror"    value="{{$post->place->address}}" placeholder="Phường(Xã)-Quận(Huyện)-Tỉnh(ThànhPhố)" name="address" id="address" required="" >
							@error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
					
					</div>
					<div class="form-group col-md-6">
						<label  for="name" class="col-form-label" > Tỉnh - Thành phố </label>
						<input type="text" autocomplete="off"  class="form-control" name="city" id="city" required="" value="{{ old('city',$post->place->districts->cities->name) }}" placeholder="Tỉnh-Thành phố" >
						<div id="errotinh" style="display: none;">
							<span style="color: red;">Không tìm thấy kết quả</span>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label  for="name" class="col-form-label" > Quận - Huyện </label>
						<input type="text" autocomplete="off"  class="form-control" name="districts_id" id="district" required="" value="{{ old('city',$post->place->districts->name) }}" placeholder="Quận-Huyện"  readonly="" >
						<div id="errohuyen" style="display: none;">
							<span style="color: red;">Không tìm thấy kết quả</span>
						</div>
					</div>

				</div>
				
				<div class="form-group">
					<label class="col-form-label "> Số điện thoại </label>
					<input type="tel" class="form-control col-md-8 @error('phone') is-invalid @enderror "  placeholder="034567890"  value="{{$post->phone}}" name="phone" id="phone">
						@error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
				</div>
				<div class="form-group">
					<label class="col-sm-2 col-form-label @error('title') is-invalid @enderror"> Title bài đăng </label>
					<input type="text" class="form-control col-md-8" placeholder="" name="title" id="title" required=""  value="{{$post->title}}">
						@error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
				</div>
				<div class="form-group">
					<label for="textarea"> Mô tả chi tiết </label>
					<textarea class="form-control" rows="15" id="editor1" name="descrice" required>{{ $post->describer }}</textarea >
						
				</div>

				<h5 class="form-control-label"> Thêm ảnh khác cho bài viết</h5>
				<div class="form-control-file">
					<input multiple type="file"  id="gallery-photo-add" class="form-control" name="filename[]" >

								<div class="gallery" style="display: flex; width: 200px;height: 200px;">
								</div>	
				</div>
				<h5> Chỉnh sửa các ảnh cũ</h5>		
				<div class="form-group">
			       <input type="text" value="" style="display: none ;"  class="form-control" id="p1" name="p1">
			    </div>		
				<div class="form-group">
					<div class="form-group d-flex" >
					 @foreach($post->photos as $p)
			          	<div id="{{$p->id}}" class="{{$p->id}}" style="display: flex; width: 150px; height: 150px; background-image: url({{"/".$p->photo_path}}); background-repeat: no-repeat; background-size: cover; margin-left: 10px;" >
				            <button id="{{$p->id}}" class="{{$p->id}} btn-success"   type="button"  style="background-image:url('https://png.pngtree.com/svg/20170521/cancle_1301160.png') ; width: 25px; height: 25px; background-repeat: no-repeat; margin: 0; padding: 0; " >
				            	X
				            </button>
				            <script type="text/javascript">
				            	$(document).ready(function(){
	                			$(".{{$p->id}}").click(function(){
					                var x =$(".{{$p->id}}");	
					                x.hide();
					                var t = document.getElementById("p1").value;
					                document.getElementById("p1").value = t +  "{{$p->id}}/";
					            });  
					            }) 
			                </script>
			              	
			          </div>
			        @endforeach
			        </div>

				</div>
				<div class="d-flex">
					<div class="justify-content-center" style="margin-left: 45% ; margin-bottom: 50px;">
						<button type="submit" class="btn btn-primary text-center"  id="submit">Lưu lại</button>
						<button type="reset" class="btn btn-dark" id="btnreset" onclick="return confirm('Có thay đổi cần lưu, bạn có chắc chắn thoát?')">Reset</button>

					</div>
				</div>
			</FORM>

		</div>


<script type="text/javascript">

    $(document).ready(function() {

	    //ckeditor
	    CKEDITOR.replace('editor1');

	    //reset all form
	    $("#btnreset").click(function(){
	    	var t = document.getElementById("p1").value;
	    	$('#formedit').trigger("reset");
	    	$('.gallery img').hide();
	    	var splitted = t.split("/");
	    	for(i=0; i<splitted.length; i++){
	    		var xmt = splitted[i];
				 //$("#splitted[i]").css("display", "block");
				 document.getElementById(xmt).style.display = 'flex';
				 // $('.xmt').show();

	    	}

	    })
	    $("#city").on('click',function(){
	    	$('#district').val('');
	    	$('#district').prop('readonly', false);
	    })

	    //ckeck lỗi nhập trk khi submit
	    $('#submit').on('click', function(){
	    	$('#errotinh').css('display') ;
	    	if($('#errotinh').css('display') == "block" || $('#errohuyen').css('display') == 'block'){
	    		alert("Erro, vui lòng kiểm tra lại thông tin");
	    		return false;
	    	}
	    })
	   
    });

   $('#gallery-photo-add').on('click', function() {
		$('.gallery img').hide();
	});

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

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    var routes = "{{ route('post.autocomplete')}}";
    $('#name').typeahead({
        source:  function (term, process) {
        return $.get(routes, { term: term }, function (data) {
                return process(data);
            });
        }
    });

    var route2 = "{{ route('post.autocompletetinh')}}";
    $('#city').typeahead({
        source:  function (term, process) {
        return $.get(route2, { term: term }, function (data) {
                if(data.length == 0){
        			$('#errotinh').css('display', 'block');
        		}
        		else{
        			$('#errotinh').css('display','none');
        		}
                return process(data);
            });
        }
    });


    var tinh;
    $("#city").blur(function(){
    	tinh = $("#city").val();
    })


    var route3 = "{{ route('post.autocompletehuyen')}}";
    $('#district').typeahead({
        source:  function (term, process) {
        return $.get(route3, { term : term , city : tinh }, function (data) {
        	    if(data.length == 0){
        			$('#errohuyen').css('display', 'block');
				    console.log($("district").val());
				    // })
        		}
        		else{
        			$('#errohuyen').css('display', 'none');        			
        		}
                return process(data);
            });
        }
    });
   

   
</script>


{{-- @push('scripts')
	<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
	<script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
	<script> CKEDITOR.replace('editor3'); </script>
@endpush --}}
	@endsection




