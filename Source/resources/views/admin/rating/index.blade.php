@extends('layouts.admin')
@section('title', '/ Rating')
@section('content')
<div class="card mb-3">
	<div class="card-header">

		<i class="fas fa-table"></i>
	Data Table Rating</div>

	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				@include('admin.rating.add')
			</div>
		</div>
	</div>

	<div class="card-body">
		<div style="margin-bottom: 15px">
			<button data-toggle="modal" data-target="#addModal" class="btn btn-success "><i class="fas fa-plus"></i> ADD</button>
		</div>
		<div class="table-responsive">
			@if (session('success'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria_label="Close">
					<span aria_hidden= "true">&times;</span>
				</button>
				{{ session('success') }}
			</div>
			@endif
			@if (session('error'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria_label="Close">
					<span aria_hidden= "true">&times;</span>
				</button>
				{{ session('error') }}
			</div>
			@endif
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Rating</th>
						<th>Comment</th>
						<th>Reviewer</th>
						<th>Title</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Rating</th>
						<th>Comment</th>
						<th>Reviewer</th>
						<th>Title</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>Action</th>
					</tr>
				</tfoot>
				<tbody>
					@if($rating)
					@foreach ($rating as $record)
					<tr>
						<td>{{$record->id}}</td>
						<td>{{$record->rating}}</td>
						<td>{!! $record->cmt !!}</td>
						<td>{{$record->user->name}}</td>
						<td>{{$record->post->title}}</td>
						<td>{{$record->created_at}}</td>
						<td>{{$record->updated_at}}</td>
						<td align="center" style="display: flex;">
							<a href="{{route('admin.rating.edit',$record->id)}}" class="btn-info nav-link" role='button'> Edit</a>
							<a href="{{route('admin.rating.delete',$record->id)}}" class="btn-danger nav-link" role='button' onclick="return confirm('Bạn có muốn xóa bản ghi này?')" style="margin-left: 5px;"> Delete</a>
						</td>
					</tr>
					@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

@endsection


