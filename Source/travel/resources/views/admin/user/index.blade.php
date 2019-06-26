@extends('layouts.admin')
@section('content')
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table User</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Username</th>
						<th>Email</th>
						<th>Status</th>
						<th>Role</th>
						<th>Create day</th>
						<th>More</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Name</th>
						<th>Position</th>
						<th>Office</th>
						<th>Age</th>
						<th>Start date</th>
						<th>Salary</th>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>Tiger Nixon</td>
						<td>System Architect</td>
						<td>Edinburgh</td>
						<td>61</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>Tiger Nixon</td>
						<td>System Architect</td>
						<td>Edinburgh</td>
						<td>61</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>Tiger Nixon</td>
						<td>System Architect</td>
						<td>Edinburgh</td>
						<td>61</td>
						<td>2011/04/25</td>
						<td align="center">
							<button type="submit" class="btn-success">Detail</button>
							<button type="submit" class="btn-info">Edit</button>
							<button type="submit" class="btn-danger">Delete</button>
						</td>
					</tr>
					<tr>
						<td>Tiger Nixon</td>
						<td>System Architect</td>
						<td>Edinburgh</td>
						<td>61</td>
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