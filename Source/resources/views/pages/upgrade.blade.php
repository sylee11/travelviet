@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h3>Edit role</h3></div>
        <div class="card-body">
          <form action="{{route('upgrade')}}" method="POST">
            @csrf
            <div class="form-group row">
             <select class="custom-select" name="role">
              <option value="1" disabled>Admin</option>
              <option value="2">Mod</option>
              <option value="3" selected>User</option>
            </select>
          </div>
          <button type="submit" class="btn btn-info">Save</button>
          <a href="{{ url('/')}}" title=""  id="edit"class="btn btn-danger">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

@endsection