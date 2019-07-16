<!-- 
<form action="" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token()}}">
	<div style="display: flex; justify-content: center; padding-top: 100px;">
		<div class="dropdown show" style="padding-right: 50px;">
			<select class="custom-select" name="" id="city">
				<option value="">Tỉnh, thành phố</option>
				
				
			</select>
		</div>

		<div class="dropdown show" style="padding-right: 50px;">
			<select class="custom-select" name="districts_id" id="district">
				<option value="">Quận huyện</option>
				
			</select>
		</div>

		<div class="dropdown show" style="padding-right: 50px;">
			<select class="custom-select" name="category_id" id="category">
				<option value="">Category</option>
				
				
			</select>
		</div>
		<div style="display: flex;">
			<a class="nav-link" href="#"><i class="fas fa-search"></i></a>
			<a class="nav-link" href="#"><i class="fas fa-map-marker-alt"></i></a>
			

		</div>

		
	</div>
</form>

<div style="justify-content: center; display: flex; margin: 50px;">
	<form class="form-inline" action="/action_page.php">
		<input class="form-control mr-sm-2" type="text" placeholder="Search">
		<button class="btn btn-success" type="submit">Search</button>
	</form>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>
<!-- <script type="text/javascript">
	$(document).ready(function{
       $(document).on('change','.category',function{
           var category_id =$(this).val();
       });
	});

</script> -->
<!-- <script type="text/javascript">
    $('#city').change(function(){
    var cityID = $(this).val();    
    if(cityID){
        $.ajax({
           type:"GET",
           url:"{{route('get_city_list')}}?cities_id="+cityID,
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
    
</script> -->
 -->