@extends('layouts.admin')
@section('title', '/ Category')
@section('content')
<script src="{{asset('js/jquery-3.2.1.slim.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>

<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
	
</script>
<div class="card mb-3">

	<div class="card-header">

		<i class="fas fa-table"></i>
	Data Table Category</div>
	<div class="card-body">
		<!-- <div style="margin-bottom: 15px"><a href="/admin/category/addlayout" class="btn btn-success "><i class="fas fa-plus"></i> ADD</a> -->
			<div style="margin-bottom: 15px">
				<button data-toggle="modal" data-target="#addModal" class="btn btn-success "><i class="fas fa-plus"></i> ADD</button>
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

									<button type="button" class="btn-success" data-toggle="modal" data-target="#detailModal" data-idcategory="{{$data->id}}" data-namecategory="{{$data->name}}">Detail</button>
									<!-- <button type="submit" class="btn-success">Detail</button> -->
									<button value="{{$data->id}}" name="edit" formaction="{{ url('admin/category/editlayout') }}" formmethod="POST" type="submit" class="btn-info">Edit</button>
									<!-- <button value="{{$data->id}}" name="id"  formaction="{{ url('/admin/category/delete') }}" formmethod="GET" type="submit" class="btn-danger">Delete</button> -->
									<button onclick="return confirm('delete?')" value="{{$data->id}}" name="delete" formaction="{{ url('admin/category/delete') }}" formmethod="POST" type="submit" class="btn-danger">Delete</button>



								</td>
							</tr>
							@endforeach

						</tbody>

					</table>

				</form>

			</div>

			<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Category</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form id="formadd" action="{{ url('admin/category/add') }}" method="POST">
								{{ csrf_field() }}
								<div class="form-group">
									<label for="" class="col-form-label">Category Name:</label>
									<input type="text" placeholder="Enter name" name="name" class="form-control" id="" required autofocus>
								</div>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button form="formadd" onclick="return confirm('Add?')" type="submit" class="btn btn-success">Add</button>
						</div>

					</div>
				</div>
			</div>


			<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Detail Category</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="detailform" action="{{ url('admin/category/edit') }}" method="POST">
								{{ csrf_field() }}
								<div class="form-group">
									<input name="id" type="hidden" id="idedit">
									<label for="category-name" class="col-form-label">Category Name:</label>
									<input type="text" name="name" class="form-control" id="category-name" readonly>
								</div>
							</form>

						</div>
						<div class="modal-footer">
							<button id="buttoncancel" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button id="buttonedit" type="button" class="btn btn-primary">Edit</button>
							<button id="buttonsave" type="button" class="btn btn-success" onclick="return confirm('Save?')" disabled>Save</button>
						</div>
					</div>
				</div>
			</div>

			<script>

				$('#detailModal').on('show.bs.modal', function(event) {
					var button = $(event.relatedTarget)
					var idcategory = button.data('idcategory')
					var namecategory = button.data('namecategory')
					var modal = $(this)
		//		document.querySelector('#idcate').value=idcategory;
		//		document.querySelector('#category-name').value="asd";
				//$("#idedit").val("2");
				modal.find('#idedit').val(idcategory);
				modal.find('#category-name').val(namecategory)
			})
		</script>
		<script>
			let editbutton = document.querySelector('#buttonedit');
			let savebutton = document.querySelector('#buttonsave');
			let cancelbutton = document.querySelector('#buttoncancel');
			let textinput = document.querySelector('#category-name');
			let detailform = document.querySelector('#detailform');
			editbutton.addEventListener('click', enableButton);
			cancelbutton.addEventListener('click', disableButton);
			savebutton.addEventListener('click', submitform);
			
			function enableButton() {
				editbutton.disabled = true;
				savebutton.disabled = false;
				textinput.readOnly = false;
				textinput.autofocus = true;
			}

			function disableButton() {
				editbutton.disabled = false;
				savebutton.disabled = true;
				textinput.readOnly = true;
			}

			function submitform() {
				detailform.submit();
			}
		</script>
	</div>
		<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
	</div>
	@endsection