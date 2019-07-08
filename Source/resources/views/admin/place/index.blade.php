@extends('layouts.admin')
@section('content')
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table Place </div>
	<div>
		<button type="button" class="btn btn-primary" >
			<a href="{{route('admin.place.add')}}" style="color: white"><i class="fas fa-plus"></i> Add</a>
		</button>
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