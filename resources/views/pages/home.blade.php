@extends('layouts.app')

@section('content')

<header>
  <div class="header-content">
    <div class="header-content-inner">
        <h1 id="homeHeading">Travel Việt - Du Lịch Trong Tầm Tay Bạn</h1>
        <hr>
        <p><h3>XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX</h3></p>
            <button data-toggle="collapse" data-target="#demo" class="btn btn-primary page-scroll ">Tìm kiếm địa điểm</button>
         <div id="demo" class="collapse">
                @include('includes.search_slide')
        </div>
    </div>
  </div>
</header>
@endsection

