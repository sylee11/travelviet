@extends('layouts.admin')
@section('content')
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table Place </div>
	<div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">
			<a><i class="fas fa-plus"></i> Add</a>
		</button>
	</div>
	<div class="modal" id="myModal1">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Thêm địa điểm </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<form action="{{route('admin.place.add')}}" method="post">
						<input type="hidden" name="_token" value="{{ csrf_token()}}">
						<div class="form-group">
							<label for="">Tên địa điểm </label>
							<input id="name" type="text" class="form-control" name="name" value=""    required autofocus >
						</div>
						<div class="form-group">
							<label for="">Address </label>
							<input id="address" type="text" class="form-control" name="address" value=""    required autofocus >
						</div>
						<div class="form-group col-md-6">
							<label for="">Category</label>
							<select class="custom-select" name="category_id">
								@if($category)
								@foreach ($category as $ca)
								<option value="{{$ca->id}}">{{$ca->name}}</option>
								@endforeach
								@endif
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="">City</label>
							<select class="custom-select" name="districts_id">
								@if($city)
								@foreach ($city as $record)
								<option value="{{$record->id}}">{{$record->name}}</option>
								@endforeach
								@endif
							</select>
						</div>

						<button type="submit" class="btn btn-primary">Add</button>
					</form>

				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>

	
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>Category</th>
						<th>Districst</th>
						<th>More</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>Category</th>
						<th>Districst</th>
						<th>More</th>
					</tr>
				</tfoot>
				<tbody>

					@foreach ($place as $key=> $p)
					<tr>
						<td>{{$p->id}}</td>
						<td>{{$p->name}}</td>
						<td>{{$p->created_at}}</td>
						<td>{{$p->updated_at}}</td>
						<td>{{$p->category->name}}</td>
						<td>{{$p ->districts->cities->name}}</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="button" class="btn-info" data-toggle="modal" data-target="#myModal">
								<a href="{{route('admin.place.edit', $p->id)}}" style="color: white">Edit</a>
							</button>

							<button type="button" class="btn-danger" >
								<a href="{{route('admin.place.delete', $p->id)}}" style="color: white" onclick="return confirm ('Bạn có muốn xóa {{$p->name}}')">Delete</a>
							</button>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection