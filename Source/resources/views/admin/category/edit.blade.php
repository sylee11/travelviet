@extends('layouts.admin')
@section('content')
<h1 class="h3 mb-3 font-weight-normal">Edit category</h1>
<form action="{{ url('admin/category/edit') }}" method="POST">
{{ csrf_field() }}
<div class="form-group">
    <input name="id" type="hidden" value="{{$data['id']}}">
    <label for="idname">Name</label>
    <input class="form-control" placeholder="{{$data['name']}}" id="idname" name="name" type="text" required>
</div> 
    <button class="btn btn-success" type="submit" >Save</button>
    <a href="/admin/category" class="btn btn-danger">Cancel</a>
</form>
@endsection