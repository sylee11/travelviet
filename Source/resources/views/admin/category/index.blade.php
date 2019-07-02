@extends('layouts.admin')
@section('content')
<script>

</script>

<div class="card mb-3">

	<div class="card-header">

		<i class="fas fa-table"></i>
		Data Table Category</div>
	<div class="card-body">
	<div style="margin-bottom: 15px"><a href="/admin/category/addlayout" class="btn btn-success "><i class="fas fa-plus"></i> ADD</a>
	</div>
		<div class="table-responsive">

			<form>
				{{ csrf_field() }}
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Time create</th>
							<th>Time modify</th>
							<th>More</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Time create</th>
							<th>Time modify</th>
							<th>More</th>
						</tr>
					</tfoot>
					<tbody>
						@foreach($categories as $key => $data)
						<tr>
							<td>{{$data->id}}</td>
							<td>{{$data->name}}</td>
							<td>{{$data->created_at}}</td>
							<td>{{$data->updated_at}}</td>
							<td align="center">


								<!-- <button type="submit" class="btn-success">Detail</button> -->
								<button value="{{$data->id}}" name="edit" formaction="{{ url('admin/category/editlayout') }}" formmethod="POST" type="submit" class="btn-info">Edit</button>
								<!-- <button value="{{$data->id}}" name="id"  formaction="{{ url('/admin/category/delete') }}" formmethod="GET" type="submit" class="btn-danger">Delete</button> -->
								<button value="{{$data->id}}" name="delete" formaction="{{ url('admin/category/delete') }}" formmethod="POST" type="submit" class="btn-danger">Delete</button>



							</td>
						</tr>
						@endforeach

					</tbody>

				</table>

			</form>

		</div>
		
			
		
	</div>

	<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection