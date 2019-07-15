@extends('layouts.app')

@section('content')
<h1 style="margin-top:75px;">Post history</h1>
@foreach ($data as $key=>$value)
<div class="card bg-light " style="text-align:left;">
    <div class="card-body">
        <h5 class="card-title"><a class="text-info" href="/detail/{{$value->id}}">{{$value->title}}</a></h5>
        <p class="card-text">{{$value->describer}}</p>
    </div>
</div>
@endforeach
@endsection