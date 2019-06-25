@extends('layouts.app')

@section('content')

<header style="position: relative;">
  <div class="header-content" style="position: absolute; top:150px;" >
    <div class="header-content-inner">
        <h1 id="homeHeading">Travel Việt - Du Lịch Trong Tầm Tay Bạn</h1>
        <hr>
        <hr align="content" width="20%" color="#227DC7" size="10px" style="padding-bottom: 1.5px;"> 
            <button data-toggle="collapse" data-target="#demo" class="btn btn-primary page-scroll ">Tìm kiếm địa điểm</button>
         <div id="demo" class="collapse">
                @include('includes.search_slide')
        </div>
    </div>
  </div>
</header>
@endsection

