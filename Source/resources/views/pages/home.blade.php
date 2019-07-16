@extends('layouts.app')

@section('content')
<header style="position: relative;">
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>

  <div class="header-content" style="position: absolute; top:150px;" >
    <div class="header-content-inner">
      <h1 id="homeHeading">Travel Việt - Du Lịch Trong Tầm Tay Bạn</h1>
      <hr>
      <hr align="content" width="20%" color="#227DC7" size="10px" style="padding-bottom: 1.5px;"> 
      <button  data-target="#demo" class="btn btn-primary page-scroll ">
      Tìm kiếm địa điểm </button>
        <form action="{{route('get.list')}}" method="post">
          <input type="hidden" name="_token" value="{{ csrf_token()}}">
          <div style="display: flex; justify-content: center; padding-top: 100px;">
            <div class="" style="padding-right: 50px;">

              <select  class="btn btn-secondary dropdown-toggle" name="cities_id" id="city" >
                <option value="">Tỉnh, thành phố</option>
                @if($city)
                @foreach ($city as  $record)
                <option value="{{$record->id}}">{{$record->name}}</option>
                @endforeach
                @endif

              </select>
            </div>

            <div class="" style="padding-right: 50px;">
              <select class="btn btn-secondary dropdown-toggle" name="districts_id" id="district">
                <option value="">Quận huyện</option>
              <!-- @foreach ($district as  $record)
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach -->
            </select>
          </div>

          <div class="" style="padding-right: 50px;">
            <select class="btn btn-secondary dropdown-toggle" name="category_id" id="category">
              <option value="">Category</option>
              @foreach ($category as $ca)
              <option value="{{$ca->id}}">{{$ca->name}}</option>
              @endforeach
            </select>
          </div>
          <div style="display: flex;">
            <button type="submit" class="btn btn-primary" id="find" >
              <a  href=""><i class="fas fa-search" style="color: white"></i></a></button>
              <button class="btn btn-primary" >
                <a class="nav-link" href="{{route('google.map')}}"><i class="fas fa-map-marker-alt" style="color: white"></i></a>
              </button>
              
            </div>
          </div>
        </form>
        <script type="text/javascript">
          $(document).ready(function(){
            $('#city').change(function(){
              var cityID = $(this).val();    

              if(cityID){
                $.ajax({
                  type:"GET",
                  url:"{{route('get.city.list')}}?cities_id="+cityID,
                  success:function(res){               
                    if(res){
                      $("#district").empty();
                      $("#district").append('<option>Quận huyện</option>');
                      $.each(res,function(key,value){
                        $("#district").append('<option value="'+key+'">'+value+'</option>');
                      });
                    }else{
                      $("#district").empty();
                    }
                  }
                });
              }else
              {
                $("#district").empty();    
              }      
            });
          });
        </script>

        <div style="justify-content: center; display: flex; margin: 50px;">
          <form class="form-inline" action="{{route('search.list')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
            <button class="btn btn-success" type="submit">Search</button>
          </form>
        </div>

      </div>
    </div>
  </header>
  @endsection


