@extends('layouts.app')
@section('content')

	<div class="container" style="margin-top: 100px">
		@if(Session::has('success'))
		<div class="alert alert-danger">
			{{Session::get('success')}}
		</div>
		@endif
		@if(Session::has('errro'))
		<div class="alert alert-danger">
			{{Session::get('errro')}}
		</div>
		@endif
		<h4 class="" style="margin-bottom: 50px;"> Quản lí user hệ thống </h4>
	</div>

	<form class="" style="display: inline-flex;" method="get" action="{{route('account.admin.searchuser')}}">
		<div class="d-flex" style="justify-content: center;">
            <input type="text" class="form-control " name="search"  style="width: 250px;margin-right: 5px;" 
                value="{{$search}}" placeholder="Nhập tên user cần tìm" >
            <button type="submit" class="btn-success btn"> Search</button>      
        </div>
	</form>
		@if($search != NUll)
			<div class="font-weight-bold">
				Đã tìm thấy <span style="color: green;">{{$user->count()}}</span> kết quả  cho từ khóa <span style="color: green"> "{{$search}}"</span>
			</div>
		@endif
		<div class="row">

	@foreach($user as $us)
	<div class=" col-lg-3" style="margin-top: 50px;">
		<img  class="card-img-top text-center" @if ($us->avatar)  src="{{$us->avatar}}" @else src="/picture/images.png" @endif   style="width: 150px; height: 150px; border-radius: 50%;"  alt="card_img " >
		<div class="card-title" style="margin-top: 10px;"> 
			<a href="" data-toggle="modal" data-target="#detailModal" data-username="{{$us->name}}" data-email="{{$us->email}}" data-birthday="{{$us->birthday}}" data-address="{{$us->address}}" data-phone="{{$us->phone}}" data-id="{{$us->id}}"  data-photo ="{{$us->avatar}}" id="xxx" class="btn-link"> <span class="font-weight-bold">{{$us->name}}</span> </a>
		</div>
		<div class="card-title text-center"><span class="font-weight-bold " style="color: blue;">Role :</span>
			@if($us->role == 1) <a href=""><span style="color: orange;"> {{__('Admin')}} </span></a>
			@elseif($us->role == 2) <span style="color: orange;">{{__('Mod')}}</span>
			@elseif($us->role == 3) <span style="color: orange;">{{__('User')}}</span>
			@endif
		</div> 
		<div class="card-title text-center"><span class="font-weight-bold" style="color: blue;">Block:</span>
			@if($us->status == 1) <span style="color: green;"> {{__('No')}} </span>
			@else <span style="color: red;"> {{__('Yess')}} </span>
			@endif
		</div>
	</div>
	@endforeach
	</div>
	 <div class="text-center w-30" style="margin-left: 45%;">
        {!! $user->links() !!}
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
                            <img src="/picture/images.png"alt="xxx" class="user-avatar text-center" style="border-radius: 50%;width: 100px; height: 100px; margin-left: 5%;" id="picture">

                            <form class="form" id="detailform" role="form" autocomplete="off" style="margin-top: 30px; " method="post"  action="">
                                {{ csrf_field() }}
                                <div> <input style="display: none;" type="text" name="id" id="id" readonly="" ></div>
                                <div class="form-group row" >
                                    <label class="col-lg-3 col-form-label form-control-label">Name</label>
                                    <div class="col-lg-6">
                                        <input class="form-control" id="dataname" name="dataname" type="text"  readonly="">
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
                                <div class="modal-footer text-center">
		            				<button  formaction="{{route('account.admin.blockuser')}}" class="btn btn-success" >Block user</button>
		            				<button formaction="{{route('account.admin.findpost')}}"  class="btn btn-dark">Tìm post</button>
		            				<button class="btn btn-danger" formaction="{{route('account.admin.deleteuser')}}" >  Xóa</button>

		                        </div>
                            </form>

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
                        var idx = button.data('id')
                        var pho = button.data('photo')
                        console.log(pho);
                        var modal = $(this)

            //      document.querySelector('#idcate').value=idcategory;
            //      document.querySelector('#category-name').value="asd";
                    //$("#idedit").val("2");
                    modal.find('#id').val(idx);
                    modal.find('#idedit').val(name);
                    modal.find('#dataname').val(name)
                    modal.find('#datamail').val(namecategory)
                    modal.find('#databirth').val(birthday)
                    modal.find('#dataaddress').val(address)
                    modal.find('#dataphone').val(phone)
                    if(pho == ''){
                        modal.find('#picture').attr("src","/picture/images.png")
                    }
                    else{
                        modal.find('#picture').attr("src", pho)
                    }
                    })
                })
        </script>
@endsection
