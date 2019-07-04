@extends('layouts.admin')
@section('content')
<h1 class="h3 mb-3 font-weight-normal">Add category</h1>
<form  action="{{ url('admin/category/add') }}" method="POST">
{{ csrf_field() }}
<div class="form-group">
    <label for="idname">Name</label>
    <input  class="form-control" placeholder="Enter name" id="idname" name="name" type="text" required >
</div>
    <button onclick="return confirm('Save?')" class="btn btn-primary" type="submit" >Save</button>
    <a href="/admin/category" class="btn btn-danger">Cancel</a>
</form>
@endsection