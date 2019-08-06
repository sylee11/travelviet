
@extends('layouts.admin')
@section('title', '/ Rating')

@section('content')

<h1 style="text-align: center;">Edit rating</h1>
<div class="card-body" style="display: flex;justify-content: center;">
	<div class="row">
		<div class="col-12">
			<form class="form-inlin justify-content-center" method="POST" action="{{route('admin.rating.update',$show->id)}}">
				{{csrf_field()}}
				<div class="form-row">
					<div class="form-group  col-md-6 dropdown">
						<label for="username">Reviewers:</label>
						<input  class="form-control" type="text" name="name_se" value="{{old('name_se', $show->user->name)}}" id="name" required>
						<input  class="form-control" type="text" name="user_id" value="{{$show->user->id}}" id="user_id" hidden>
						<div id="error" style="display: none;color: red;font-weight: bold;">Không có trong danh sách</div>
					</div>
					<div class="form-group  col-md-6">
						<label for="rating">Rating:</label>
						<input type="number" class="form-control" id="rating"  value='{{old('rating', $show->rating)}}' placeholder="Enter Rating" name="rating" required min="1" max="5">
						@if ($errors->has('rating'))
						<span class="text-danger">{{ $errors->first('rating') }}</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label for="post">Post:</label>
					<input  class="form-control" type="text" name="title" value="{{old('title', $show->post->title)}}" id="title" required>
					<input  class="form-control" type="text" name="post_id" value="{{$show['post_id']}}" id="post_id" hidden>
					<div id="error2" style="display: none;color: red;font-weight: bold;">Không có trong danh sách</div>
				</div>
				<div class="form-group">
					<label for="comment">Comment:</label>
					<textarea class="form-control" rows="5" id="editor2" name="comment">{{old('comment',$show->cmt)}}</textarea>
					@if ($errors->has('comment'))
					<span class="text-danger">{{ $errors->first('comment') }}</span>
					@endif
				</div>
				<div class="modal-footer">
					<a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
					<button type="submit" class="btn btn-success" id="submit">Edit</button>

				</div>
			</form>
		</div>
	</div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script>
	var editor= CKEDITOR.replace('editor2');
	var path = "{{ route('admin.rating.select') }}";
	var $input1 = $("#name");
	var $input2= $("#title");

	$input1.typeahead({
		source: function (query1, process) {
			$.ajax({
				url: "{{route('admin.rating.select')}}",
				type: 'GET',
				dataType: 'JSON',
				data: 'query2=' + query1,
				success: function(data) {
					if(data.user.length != 0){
						$('#error').hide();
						var newData = [];
						$.each(data['user'],function(key,value){
						//console.log(value);
						newData.push(value);
					});
						return process(newData);
					}else{
						$('#error').show();
						return process("");
					}
				}
			});
		},
		displayText: function (item) {
			return item.name;
		},
		afterSelect: function(args){
			$('#user_id').val(args.id);
		}
	});
	$(document).ready(function(){
		$("#name").keyup(function(){
			$('#error').hide();
		});
		$("#title").keyup(function(){
			$('#error2').hide();
		});
	});

	$input2.typeahead({
		source: function (query2, process) {
			$.ajax({
				url: "{{route('admin.rating.select')}}",
				type: 'GET',
				dataType: 'JSON',
				data: 'query=' + query2,
				success: function(data) {
					console.log(data.post);
					if(data.post.length != 0){
						$('#error2').hide();
						var postData = [];
						$.each(data.post,function(key,value){
							postData.push(value);

						});
						return process(postData);
					}else{
						$('#error2').show();
						return process("");
					}
				},
			});
		},
		displayText: function (item) {
			return item.title;
		},
		afterSelect: function(args){
			$('#title').val(args.title);
			$('#post_id').val(args.id);
		}
	});

</script>
@endpush