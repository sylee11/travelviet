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
    <div class="row " id="" style="margin-bottom: 50px;">
        <div class="card col-md-12">
            <img class="card-img-top" src="/{{$p->photo_path}}" alt="card_img">
            <div class="card-body">
                <div class="card-title font-weight-bold text-center ">
                    {{$p->title}}
                </div>
                <div class="card-title">
                    <span class="font-weight-bold">
                        Author:
                    </span>
                    <a href="/user/{{$p->user_id}}"> {{$p->name}} </a>
                </div>
                <div class="card-title">
                    <span class="font-weight-bold">
                        Descrice:
                    </span>
                    {!! $p->describer !!}
                </div>
                <a class="btn btn-primary" href="/detail/{{$p->slug}}">
                    See more ...
                </a>
                <a class="btn btn-success" onclick="" href="{{route('approved', $p->id)}}" id="">
                    Phê duyệt
                </a>
                <form method="delete" >
                        @csrf
                        <input type="" name="iddelete" value="{{$p->id}}" style="display: none;">
                        <button class="btn btn-dark text-center"  formaction="{{route('approved/deletepost')}}"  onclick="return confirm('Bạn có muốn xóa bài đăng này?')" formmethod="post">
                            Xóa
                        </button>
                    </form>
            </div>

        </div>

    </div>
    @endforeach

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