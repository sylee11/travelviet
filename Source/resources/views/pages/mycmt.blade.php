@extends('layouts.app')

@section('content')
<div style='text-align:left;margin-top:75px;' class="container">

    @foreach ($data as $key=>$value)
    <div class="">
        <h1><a href="/detail/{{$value->id}}">{{$value->title}}</a></h1>
        <p>{{$value->cmt}}</p>
        @for($i=1;$i<= $value->rating;$i++) <span style="color:orange;font-size: 50px" class="fa fa-star "></span>
          
            @endfor
    </div>
    @endforeach


</div>



@endsection