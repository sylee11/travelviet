@extends('layouts.admin')
@section('content')
<div class="card mb-3">
	<div class="card-header">
		<i class="fas fa-table"></i>
	Data Table Post</div>
	<div class="card-body">
		<div class="table-responsive">
			<a href="" class="nav-link btn-info"  role = "button" style=" width: 120px; margin: 10px;" data-toggle="modal" data-target="#myModal3"> Add new</a>
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

					@foreach($posts as $post)
					    <tr>
					        <th>{{ $post-> id }}</th>
					        <th>{{ $post->title }}</th>
					        <th>{{ $post->user->name }}</th>
					        <th>@if($post->is_approved ==1)
					        		<div style="display: flex;">
					        		Approved  
					        		<a href="{{route('admin.post.unapproved', $post->id)}}" onclick="return confirm('Xác nhận hủy đăng bài này?')" role="button" class="btn-danger nav-link" style="width: 50px; height: 40px; margin-left: 10px;" > Unb</a>
					        	</div>
					        	@else 
					        	<div style="display: flex;">
					        		Unapproved  
					        		<a href="{{route('admin.post.approved', $post->id)}}" onclick="return confirm('Xác nhận đăng bài này?')" role="button" class="btn-success nav-link" style="width: 50px; height: 40px; margin-left: 10px;" > Enb</a>
					        	</div>
					        	@endif </th>
					        <th>{{ $post->place_id }}</th>
					        
					        <th>{{ $post->created_at }}</th>
					        <th>{{ $post->updated_at }}</th>
					        
					        <td align="center" style="display: flex;">
								<a href="{{route('admin.post.detail', $post->id)}}" class="btn-success nav-link"> Detail</a>
								
								<a href="{{route('admin.post.showedit', $post->id)}}" class="btn-info nav-link" role='button'> Edit</a>
								<a href="{{ route('admin.post.delete', $post->id)}}" class="btn-danger nav-link" role='button' onclick="return confirm('Bạn có muốn xóa bản ghi này?')"> Delete</a>
							</td>
					    </tr>

					@endforeach

				</tbody>
			</table>
		</div>
	</div>
	<div class="modal" id="myModal3">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header" style="">
        <h4 class="modal-title " style="width: 100%; text-align: center;">Add new post</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      		@include('admin.post.add')
      <!-- Modal body -->
      <div class="modal-body">
        <div></div>
      </div>

      <!-- Modal footer -->
{{--       <div class="modal-footer">
        <a type="button" class="btn btn-success" href="{{route('admin.post.add')}}">Add</a>
      </div> --}}

    </div>
  </div>
</div>

<div class="modal" id="myModal4">
  	<div class="modal-dialog">
    	<div class="modal-content">

      	<!-- Modal Header -->
      <div class="modal-header" style="">
        <h4 class="modal-title">Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
{{--       		@include('admin.post.detail')
 --}}      <!-- Modal body -->
      <div class="modal-body">
        <div></div>
      </div>

      <!-- Modal footer -->
{{--       <div class="modal-footer">
        <a type="button" class="btn btn-success" href="{{route('admin.post.add')}}">Add</a>
      </div> --}}

    </div>
  </div>
</div>
	<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
@endsection