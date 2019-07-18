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
                    <div class="card-body " style="height: 300px; overflow: hidden;text-overflow: ellipsis;">
                        <div class="card-title font-weight-bold text-center ">
                            {{$p->title}}
                        </div>
                        <div class="card-title">
                            <span class="font-weight-bold">
                                Author:
                            </span>
                            <a href="" data-toggle="modal" data-target="#detailModal" data-username="{{$p->name}}" data-email="{{$p->email}}" data-birthday="{{$p->birthday}}" data-address="{{$p->address}}" data-phone="{{$p->phone}}" id="xxx" class="btn-link">{{$p->name}} </a>
                        </div>
                        <div class="card-title">
                            <span class="font-weight-bold">
                                Time: 
                            </span>
                            {{ date('d-m-Y', strtotime($p->created_at)) }}
                        </div>
                        <div class="card-title" style="height: 100px;">
                            <span class="font-weight-bold">
                                Descrice:
                            </span>
                            {{str_limit($p->describer, 65)}}
                            <a class="" href="{{route('detail', $p->postid)}}">
                                See more
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
                        Chưa phê duyệt
                    </span>
                    @else
                    <span class="font-weight-bold">
                        Đã phê duyệt
                    </span>
                    @endif
                </div>
                <div>
                    Action:
						@if($p->is_approved == 0)
                    <a class="btn btn-success " href="{{route('approved', $p->postid)}}" id="{{$p->postid}}">
                        Duyệt
                    </a>
                    @else
                    <a class="btn btn-danger text-center" href="{{route('approved', $p->postid)}}">
                        Hủy Duyệt
                    </a>
                    @endif
                    <a class="btn btn-dark text-center" href="{{route('delete', $p->postid)}}" onclick="return confirm('Bạn có muốn xóa bài đăng này?')">
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
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thông tin user</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="/picture/images.png"alt="xxx" class="user-avatar text-center" style="border-radius: 50%;width: 100px; height: 100px; margin-left: 40%;">

                            <form class="form" id="detailform" role="form" autocomplete="off" style="margin-top: 30px; " method="get">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Name</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="dataname" type="text"  disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="datamail" type="email"  disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Birthday</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="databirth" type="text " disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Address</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="dataaddress" type="text"  disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label form-control-label">Phone</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="dataphone" type="text"  disabled>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
            
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function(){
                    $('#detailModal').on('show.bs.modal', function(event) {
                        var button = $(event.relatedTarget)
                        var name = button.data('username')
                        var namecategory = button.data('email')
                        var birthday = button.data('birthday')
                        var address = button.data('address')
                        var phone = button.data('phone')
                        var modal = $(this)
            //      document.querySelector('#idcate').value=idcategory;
            //      document.querySelector('#category-name').value="asd";
                    //$("#idedit").val("2");
                    modal.find('#idedit').val(name);
                    modal.find('#dataname').val(name)
                    modal.find('#datamail').val(namecategory)
                    modal.find('#databirth').val(birthday)
                    modal.find('#dataaddress').val(address)
                    modal.find('#dataphone').val(phone)
                    })
                })
        </script>

</div>
@endsection
