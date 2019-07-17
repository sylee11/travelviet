@extends('layouts.app')
@section('content')
<div class="container " style="margin-top: 200px; text-align: left;">
    <h3 class="card-title text-center " style="margin: 100px;">
        Phê duyệt bài viết
    </h3>
    @if($data->count()==0)
    <h4 class="text-center">
        {{"Tất cả bài viết đã được phê duyệt"}}
    </h4>
    <h4 class="text-center" style="margin-bottom: 200px;">
        Xem tất cả bài viết
        <a href="{{route('approved.all')}}">
            tại đây
        </a>
    </h4>
    @else
		@foreach($data as $p)
    <div class="row " id="{{$p->id}}" style="margin-bottom: 50px;">
        <div class="card col-md-4">
            <img ".$p-="" class="card-img-top" src="{{">
                photo_path}}" alt="card_img" >
                <div class="card-body" style="width: 300px;">
                    <div class="card-title font-weight-bold text-center ">
                        {{$p->title}}
                    </div>
                    <div class="card-title">
                        <span class="font-weight-bold">
                            Author:
                        </span>
                        {{$p->name}}
                    </div>
                    <div class="card-title">
                        <span class="font-weight-bold">
                            Descrice:
                        </span>
                        {{$p->describer}}
                    </div>
                    <a class="btn btn-primary" href="#">
                        See more ...
                    </a>
                </div>
            </img>
        </div>
        <div class="col-md-4 ">
            <div class="align-middle text-center">
                <a class="btn btn-success " href="{{route('approved', $p->id)}}" id="{{$p->id}}">
                    Phê duyệt
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <a class="btn btn-danger text-center" href="{{route('delete', $p->id)}}">
                Xoá bài viết
            </a>
        </div>
    </div>
    @endforeach
    <div class="row m-auto">
        <div class="col-6">
            <a class="btn btn-success text-center" href="">
                Phê duyệt tất cả
            </a>
        </div>
        <div class="col-6">
            <a class="btn btn-danger text-center" href="">
                Xóa tất cả
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
{{--
<script type="text/javascript">
    $('#{{$p->id}}').click(function() {
    	location.reload();
	});
</script>
--}}
