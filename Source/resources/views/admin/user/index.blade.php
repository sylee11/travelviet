@extends('layouts.admin')
@section('content')
<!-- @if (Session ::has('success'))
    <h3>{{Session :: get('success')}}</h3>
@endif -->
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table User </div>
	<div class="container">
		
		<!-- Button to Open the Modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">
			<a><i class="fas fa-plus"></i> Add</a>
		</button>

		<!-- The Modal -->
		<div class="modal" id="myModal1">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Thêm User </h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<!-- Modal body -->
					<div class="modal-body">
						<form action="{{route('admin.user.add')}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token()}}">
							<div class="form-group">
								<label for="">Username </label>
								<input id="name" type="text" class="form-control" name="name" value=""    required autofocus >
							</div>
							<div class="form-group">
								<label for="inputEmail4">Email</label>
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  >
							</div>
							<div class="form-group">
								<label for="">Passwword</label>
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"   >
							</div>
							<div class="form-row">
								
								<div class="form-group col-md-4">
									<label for="inputState">Role</label>
									<select id="inputState" class="form-control" name="role">
										<option selected value="1">admin</option>
										<option value="2">Người đăng bài</option>
										<option value="3">Người Xem</option>
									</select>
								</div>
								
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
	</div>
    
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
				@foreach ($user as $key=> $u)
				<tr>
					<td>{{$u->name}}</td>
					<td>{{$u->email}}</td>
					<td>{{$u->status}}</td>
					<td>{{$u->role}}</td>
					<td>{{$u->created_at}}</td>
						<td align="center">
							<button type="submit" class="btn-success">
								<a href="{{route('admin.user.block', $u->id)}}" style="color: white" onclick="return confirm ('bạn có muốn block user {{$u->name}} này')">Block</a>
							</button>
						    
							<button type="button" class="btn-info" data-toggle="modal" data-target="#myModal">
							   <a href="{{route('admin.user.edit', $u->id)}}" style="color: white">Edit</a>
							</button>

							<!-- The Modal -->
							
							<button type="button" class="btn-danger" >
							<a href="{{route('admin.user.delete', $u->id)}}" style="color: white" onclick="return confirm ('bạn có muốn xóa user {{$u->name}}')">Delete</a>
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
