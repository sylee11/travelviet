@extends('layouts.app')
@section('content')
<div class="container " style="margin-top: 200px; text-align: left;">
    <h3 class="card-title text-center " style="margin: 100px;">
        Phê duyệt bài viết
    </h3>
    <div class="row">
        <form action="{{route('approved.all')}}" class="form-inline w-100" method="get" style="margin-bottom:  20px; ">
            <label style="margin-left: 100px;">
                Bộ lọc:
            </label>
            <select class="form-control w-40" id="chose" name="chose">
                <option 
                    @if($selec == "Tất cả bài viết") selected="selected"
                    @endif>
                        Tất cả bài viết
                </option>
                <option  
                    @if($selec=="Bài viết chưa duyệt") selected="selected"
                    @endif>
                        Bài viết chưa duyệt                    
                </option>
                <option   
                    @if($selec=="Bài viết đã duyệt") selected="selected"
                    @endif>
                        Bài viết đã duyệt
                </option>
            </select>
            <button class="btn btn-success">
                Lọc
            </button>
            <select class="form-control" name="chose2" style="margin-left: 200px">
                <option  
                    @if($chose=="Actor") selected="selected"
                    @endif>
                        Actor
                </option>
                <option  
                    @if($chose=="Địa điểm") selected="selected"
                    @endif>    
                        Địa điểm
                    
                </option>
            </select>
            <input class="form-control" name="search" placeholder="input here" type="text" value="{{$search}}">
                <button class="btn btn-success" formaction="{{route('approved.search')}} " type="submit">
                    Search
                </button>
            </input>
        </form>
        {{--
        <form action="{{route('approved.search')}}" class="form-inline col-6 " method="get" style="margin-bottom: 20px;">
            <select class="form-control" name="chose2">
                <option>
                    Actor
                </option>
                <option>
                    Địa điểm
                </option>
            </select>
            <input class="form-control" name="search" placeholder="input here" type="text" value="search">
                <button class="btn btn-success">
                    Search
                </button>
            </input>
        </form>
        --}}
    </div>
    @if($data->count()==0)
    <h4 class="text-center">
        {{"Rất tiết không có bài viết đề hiển thị"}}
    </h4>
    <h4 class="text-center" style="margin-bottom: 200px;">
    </h4>
    @else
    <div class="row " id="zz" style="margin-bottom: 50px;">
        @foreach($data as $p)
        <div class="col-lg-3" style="margin-bottom: 50px;">
            <div class="card col-lg">
                <img  class="card-img-top" src="{{"/".$p->photo_path}}" style="width: 220px; height: 200px;" alt="card_img" >
                    <div class="card-body">
                        <div class="card-title font-weight-bold text-center ">
                            {{$p->title}}
                        </div>
                        <div class="card-title">
                            <span class="font-weight-bold">
                                Author:
                            </span>
                            {{$p->name}}
                        </div>
                        <div class="card-title" style="height: 100px;">
                            <span class="font-weight-bold">
                                Descrice:
                            </span>
                            {{$p->describer}}
                            <a class="" href="#">
                                See more ...
                            </a>
                        </div>
                    </div>
                </img>
            </div>
            <div class="card col-lg ">
                <div class="">
                    Trạng thái: 
						@if($p->is_approved == 0)
                    <span class="font-weight-bold">
                        Đã phê duyệt
                    </span>
                    @else
                    <span class="font-weight-bold">
                        Chưa phê duyệt
                    </span>
                    @endif
                </div>
                <div>
                    Action:
						@if($p->is_approved == 0)
                    <a class="btn btn-success " href="{{route('approved', $p->id)}}" id="{{$p->id}}">
                        Duyệt
                    </a>
                    @else
                    <a class="btn btn-danger text-center" href="{{route('approved', $p->id)}}">
                        Hủy Duyệt
                    </a>
                    @endif
                    <a class="btn btn-dark text-center" href="{{route('delete', $p->id)}}" onclick="return confirm('Bạn có muốn xóa bài đăng này?')">
                        Xóa
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
		@if($selec =="Bài viết chưa duyệt")
    <div class="d-flex w-100" style="margin: 50px 40%;">
        <a class="btn btn-success text-center w-25 justify-content-center " href="{{route('approved.appectall')}}" onclick="return confirm('Bạn có muốn phê duyệt tất cả các bài đăng này?')">
            Phê duyệt tất cả
        </a>
    </div>
    @elseif($selec =="Bài viết đã duyệt")
    <div class="d-flex w-100" style="margin: 50px 40%;">
        <a class="btn btn-danger text-center w-25 " href="{{route('approved.unappectall')}}" onclick="return confirm('Bạn có muốn hủy tấy cả các bài đăng này?')">
            Hủy phê duyệt tất cả
        </a>
    </div>
    @endif
		{{--
    <nav aria-label="Page navigation example " style="margin: 0 42%;">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#">
                    Previous
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">
                    1
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">
                    2
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">
                    3
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">
                    Next
                </a>
            </li>
        </ul>
    </nav>
    --}}
    <div class="text-center w-30" style="margin-left: 45%;">
        {!! $data->links() !!}
    </div>
</div>
@endsection
