@push('css')
<link href="{{asset('css/custom/front.css')}}" rel="stylesheet">
@endpush
@extends('layouts.app')
@section('content')

<div class="container-fluid">
	<div style="text-align: center;margin-top:100px;color: black;margin-bottom: 50px;"><h2>Tất cả các bài viết</h2></div>
	
	<form class="form-inline" style="justify-content: center;" >
		<input type="text" autocomplete="off"  class="form-control" name="place" id="place" required="" value="" placeholder="Nhập địa điểm" style="width: 300px;">
	</form>
	<div id="count" style="color: green;font-weight: bold;margin-top: 10px;"></div>

<div class="row" style="justify-content: center;">
	<div class="col-sm-3" style="width: 100%;background-color: #e2e2e2;margin:60px 0;    text-align: left;height: 100%;padding: 20px;">
		<h4>Bộ lọc tìm kiếm</h4>
		<hr>
		<label  for="name" class="col-form-label" > Tỉnh - Thành phố </label>
		<input type="text" autocomplete="off"  class="form-control" name="city" id="city" required="" value="" placeholder="Tỉnh-Thành phố" >
		<label for="cate1" class="col-form-label"  > Category </label>
		<select class="custom-select" class="col-md-2" id="category" name="category">
			<option value="0" default> Danh mục</option>
			@foreach($category as $ca)
			<option value="{{$ca->id}}"> {{$ca->name}} </option>
			@endforeach
		</select>
	</div>
	<div class="col-sm-9" style="width: 100%;margin:50px 0;">
		<div class="row"  id="search" style="justify-content: center;">
		</div>

	</div>

</div>


</div>
{{-- <div style="display: inline-block;">{{$all_posts->links()}}</div>
 --}}<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
	var city;
	var place= '';
	var city_input = '';
	var category= $('#category').val();
	var route2 = "{{ route('search.posts')}}";
	$('#city').typeahead({
		source:  function (query, process) {
			$.ajax({
				url: "{{route('search.posts')}}",
				type: 'GET',
				dataType: 'JSON',
				data:'search_city=' + query,
				success: function(data) {
					return process(data.city);
				},
			});
		},
		afterSelect: function(args){
			$('#city').val(args.name);
			city_selected=args.name;
			category= $('#category').val();
			$.ajax({
				url:"{{ route('search.posts') }}",
				method:'GET',
				data:{city_selected:city_selected,query7:place,category:category},
				dataType:'json',
				success:function(data)
				{
					$('#search').html(data.data1.table_data);
					$('#count').text("Có "+data.data1.total_data+" kết quả được tìm thấy");
				}
			})
		}
	});


	$(document).ready(function(){
		fetch_customer_data();
		$('#category').on('change', function(){
			place= $('#place').val();
			city_input= $('#city').val();
			category= $('#category').val();
			fetch_customer_data(place,city_input,category);
			$.ajax({
				url:"{{ route('search.posts') }}",
				method:'GET',
				data:{place:place,city_input:city_input,category:category},
				dataType:'json',
				success:function(data) 
				{
					$('#search').html(data.data1.table_data);
					$('#count').text("Có "+data.data1.total_data+" kết quả được tìm thấy");
				}
			})
		});
		function fetch_customer_data(place = '',city_input = '',category = 0)
		{
			$.ajax({
				url:"{{ route('search.posts') }}",
				method:'GET',
				data:{place:place,city_input:city_input,category:category},
				dataType:'json',
				success:function(data) 
				{
					$('#search').html(data.data1.table_data);
					$('#count').text("Có "+data.data1.total_data+" kết quả được tìm thấy");
				}
			})
		}

		$(document).on('keyup', function(){
			var place = $('#place').val();
			place= $('#place').val();
			city_input =$('#city').val();
			//console.log("t"+query1);
			fetch_customer_data(place,city_input,category);
		});
	});
</script>

@endsection