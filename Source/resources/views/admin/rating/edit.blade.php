@extends('layouts.admin')
@section('content')

<div class="card-body">
	<div class="row">
		<div class="col-8">
			<form class="form-inlin justify-content-center" method="POST" action="{{route('admin.rating.add')}}">
				{{csrf_field()}}
				<div class="form-row">
					<div class="form-group  col-md-6">
						<label for="username">Reviewers:</label>
						<select class="custom-select">
							@if($user)
							@foreach ($user as $record)
							<option value="{{$record->id}}" @if($show['user_id'] == $record['id']) selected @endif>{{$record->name}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group  col-md-6">
						<label for="fullname">Rating:</label>
						<input type="text" class="form-control" id="rating"  value='{{$show->rating}}' placeholder="Enter Rating" name="rating" autofocus required>
					</div>
				</div>

				<div class="form-group">
					<label for="post">Post:</label>
					<select class="custom-select">
						@if($post)
						@foreach ($post as $record1)
						<option value="{{$record1->id}}" @if($record1['id'] == $show['post_id']) selected @endif>{{$record1->title}}
						</option>
						@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label for="comment">Comment:</label>
					<textarea class="form-control" rows="5" id="comment" name="comment">{{$show->cmt}}</textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success">Add</button>

				</div>
			</form>
		</div>
	</div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection