@extends('layouts.admin')
@section('title', '/ Rating')
@section('content')
<h1>Edit rating</h1>
<div class="card-body">
	<div class="row">
		<div class="col-8">
			<form class="form-inlin justify-content-center" method="POST" action="{{route('admin.rating.update',$show->id)}}">
				{{csrf_field()}}
				<div class="form-row">
					<div class="form-group  col-md-6">
						<label for="username">Reviewers:</label>
						<select class="custom-select" name="user_id">
							@if($user)
							@foreach ($user as $record_user)
							<option value="{{$record_user->id}}" @if($show->user_id == $record_user->id) selected @endif>{{$record_user->name}}</option>
							@endforeach
							@endif
						</select>
					</div>
					<div class="form-group  col-md-6">
						<label for="fullname">Rating:</label>
						<input type="text" class="form-control" id="rating"  value='{{$show->rating}}' placeholder="Enter Rating" name="rating" autofocus required>
						@if (session('error1'))
						<span class="help-block">
							<strong style="color: red;">{{ session('error1') }}</strong>
						</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<label for="post">Post:</label>
					<select class="custom-select" name="post_id">
						@if($post)
						@foreach ($post as $record)
						<option value="{{$record->id}}" @if($record['id'] == $show['post_id']) selected @endif>{{$record->title}}
						</option>
						@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label for="comment">Comment:</label>
					<textarea class="form-control" rows="5" id="editor2" name="comment">{{$show->cmt}}</textarea>
					@if (session('error2'))
					<span class="help-block">
						<strong style="color: red;">{{ session('error2') }}</strong>
					</span>
					@endif
				</div>
				<div class="modal-footer">
					<a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
					<button type="submit" class="btn btn-success">Edit</button>

				</div>
			</form>
		</div>
	</div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script> 
	CKEDITOR.replace('editor2');
	CKEDITOR.config.font_defaultLabel = 'Arial'; 
	CKEDITOR.config.fontSize_defaultLabel = '10px';
	CKEDITOR.config.entities = true;
	CKEDITOR.config.basicEntities = true;
	CKEDITOR.config.entities_greek = false;
	CKEDITOR.config.entities_latin = false;
	CKEDITOR.config.forcePasteAsPlainText = true;
</script>
@endpush