@extends('layouts.admin')
@section('content')
    <div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table Rating</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>ID</th>
						<th>Rating</th>
						<th>Comment</th>
						<th>Reviewers</th>
						<th>ID_post</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>More</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Rating</th>
						<th>Comment</th>
						<th>Reviewers</th>
						<th>ID_post</th>
						<th>Time create</th>
						<th>Time modify</th>
						<th>More</th>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>1</td>
						<td>4</td>
						<td>Đẹp</td>
						<td>Bii</td>
						<td>22</td>
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
						<td>4</td>
						<td>Đẹp</td>
						<td>Bii</td>
						<td>22</td>
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
						<td>4</td>
						<td>Đẹp</td>
						<td>Bii</td>
						<td>22</td>
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
						<td>4</td>
						<td>Đẹp</td>
						<td>Bii</td>
						<td>22</td>
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