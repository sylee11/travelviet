@extends('layouts.admin')
@section('content')
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table Post</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Author</th>
						<th>Status approved</th>
						<th>Place</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>More</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Title</th>
						<th>Author</th>
						<th>Status approved</th>
						<th>Place</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>More</th>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>1</td>
						<td>Địa điểm vàng</td>
						<td>Edinburgh</td>
						<td>Đang hoạt động</td>
						<td>Chùa linh ứng</td>
						<td>2011/04/25</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>Địa điểm vàng</td>
						<td>Edinburgh</td>
						<td>Đang hoạt động</td>
						<td>Chùa linh ứng</td>
						<td>2011/04/25</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>Địa điểm vàng</td>
						<td>Edinburgh</td>
						<td>Đang hoạt động</td>
						<td>Chùa linh ứng</td>
						<td>2011/04/25</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>1</td>
						<td>Địa điểm vàng</td>
						<td>Edinburgh</td>
						<td>Đang hoạt động</td>
						<td>Chùa linh ứng</td>
						<td>2011/04/25</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection