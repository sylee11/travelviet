@extends('layouts.app')

@section('content')

<h1 style='text-align:center;margin-top:100px;'> 
@if($data->count()!==0){{ $data[0]->name }}
@else NULL
@endif
</h1>
<div style='text-align:left;margin:20px auto;width:75%' class="list-group">
    @foreach ($data as $key=>$value)
    <a href="/detail/{{$value->slug}}" class="list-group-item list-group-item-action ">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">Title: {{$value->title}}</h5>
            <small>{{ date('d-m-Y', strtotime($value->created_at)) }}</small>
        </div>
        <p class="mb-1">{!!$value->cmt!!}</p>
        @for($i=1;$i<= $value->rating;$i++) <span style="color:orange;font-size: 50px" class="fa fa-star "></span>

            @endfor
    </a>
    @endforeach
</div>


@endsection