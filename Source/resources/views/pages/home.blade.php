@extends('layouts.app')

@section('content')

<header style="position: relative;">
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>

  <div class="header-content" style="position: absolute; top:150px;" >
    <div class="header-content-inner" style="font-family: 'Lobster', cursive;
">

      <h1 id="homeHeading" style="">Travel Việt - Du Lịch Trong Tầm Tay Bạn</h1>
      <hr align="content" width="20%" color="#3997A6" size="5px" style="padding-bottom: 1.5px;"> 
     {{--  <button  data-target="#demo" class="btn btn-primary  " style="width: 150px; height: 50px; border-radius: 20px; background-color: #3997A6">
      Tìm kiếm địa điểm </button> --}}
      <div style="display: flex;justify-content: center;">
      <form action="{{route('get.list')}}" method="get" >
        <!-- <input type="hidden" name="_token" value="{{ csrf_token()}}"> -->
        <div style=" padding-top: 40px;" class="row">
          <div class="col-lg-3" style="padding-right: 50px;">
             <select  class="btn  dropdown-toggle" style="background-color: #467F3E; color: white; border-radius: 10px; height: 40px; width: 180px; margin-bottom: 10px;" name="cities_id" id="city" >
              <option value="">Tỉnh, thành phố</option>
              @if($city)
              @foreach ($city as  $record)
              <option value="{{$record->id}}">{{$record->name}}</option>
              @endforeach
              @endif
            </select>
          
          </div>
          <div class="col-lg-3" style="padding-right: 50px;">
            <select class="btn btn-secondary dropdown-toggle" name="districts_id" id="district" style="background-color: #467F3E; color: white; height: 40px; border-radius: 10px; width: 180px; margin-bottom: 10px;">
              <option>Quận,huyện</option>

            </select>

          </div>
          <div class="col-lg-3" style="padding-right: 50px;">
            <select class="btn btn-secondary dropdown-toggle dropdown-menu-lg-right" name="category_id" id="category" style="background-color: #467F3E; color: white; height: 40px; border-radius: 10px; width: 180px; margin-bottom: 10px;">
              <option value="">Category</option>
              @foreach ($category as $ca)
              <option value="{{$ca->id}}">{{$ca->name}}</option>
              @endforeach
            </select>
          </div>
            <div style="padding-right: 40px;" class="col-lg-3">
              <button type="submit" class="btn btn-primary" id="find" style="height: 37px; background-color: #3997A6" >
                <i class="fas fa-search" style="color: white "></i></button>

              <a style="height: 37px; margin-left: 30px; background-color: #3997A6   "class="btn btn-primary" href="{{route('google.map')}}"><i class="fas fa-map-marker-alt " style="color: white; " ></i></a>
              
            </div>

            </div>
          </form>

        </div>
         
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
                      $("#district").append('<option>Quận,huyện</option>');
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
        
        <div class="align-middle" id="searchhead">
          <form class="form-inline" action="{{route('search.list')}}" method="get">   
            <div class="row">        
            <div>
               <input class="typeahead form-control mr-sm-2" type="text" placeholder="Search" name="search" required="" id="inputsearch" autocomplete="off">
            </div>
                 
            <div>
              <button class="btn " type="submit" style="background: #FB8B34; color: white; " id="btnsearch"> <span class="font-weight-bold" >Search </span></button>
            </div>
            </div>
          </form>
        
        </div>
        
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script type="text/javascript">
      var path = "{{ route('autocomplete') }}";
      $('input.typeahead').typeahead({
        source:  function (query, process) {
          return $.get(path, { query: query }, function (data) {
            return process(data);
          });
        }
      });
    </script>
  </div>
</header>
<div class="" style="box-sizing: border-box; width: 100%; background-color: #3BB5C9; margin: 0px; color: white;" id="about">
  <div class="row" style="width: 100%; box-sizing: border-box;" style="margin:0px; padding: 0px" >
      <div class="col-lg-12 col-lg-offset-2">
        <h2 class="section-heading text-center" style="margin: 50px 0px 0px 0%; padding: 0px;">PHƯƠNG CHÂM CỦA CHÚNG TÔI
          <i class="fa fa-heart text-primary heart-icon" style="color: red"></i>
        </h2>
        <hr align="content" width="20%" color="white" size="5px" style="padding-bottom: 1.5px;"> 

      </div>
      <div class="" style="width: 50%; margin-left: 25%; ">
        <p class="" style="color: white; font-size: 20px;">Lập kế hoạch và thực hiện một chuyến đi thú vị và đầy đủ cũng giống như pha một loại đồ uống tốt. Mỗi bước đòi hỏi sự kiên nhẫn và chú ý cẩn thận, nếu quá trình không được tuân thủ tốt, kết quả cuối cùng thường có thể khá áp đảo, để lại vị đắng sau khi nếm.
          <br/><br/>
          Tại  Travel Việt, chúng tôi rất chú trọng đến các giai đoạn lập kế hoạch chuyến đi khác nhau, từ lên ý tưởng đến lựa chọn hành trình tốt nhất có thể và cuối cùng là thực hiện. Nỗ lực là cung cấp một cái gì đó độc đáo, nơi bạn có thể khám phá những cảnh đẹp ở châu Âu giống như một người dân địa phương.
          <br/><br/>
          Không còn lịch trình nhàm chán và hành trình cố định, chúng tôi cung cấp cho bạn các gói kỳ nghỉ quốc tế giá cả phải chăng cho phép bạn tự do không giới hạn.
          <p><h2 class="text-center">#teamTravelViet</h2></p>
          </p>
      </div>
  </div>
  <div class="icon-aboutus row" style="margin-top: 50px;  width: 60%; margin-left: 20%;">
      <div class="col-md-4 text-center">
        <img class="img-icon" src="/picture/front/balloon.png" title="Snorkel" alt="Image of a snorkel, Explore the hidden gems of the city with guided tours and suggestions by travel brewery" style="width: 100px; height: 100px;">
        <h4 style="margin: 20px;">LÊN Ý TƯỞNG </h4>
      </div>
      <div class="col-md-4 text-center">
        <img class="img-icon" src="/picture/front/compass.png" title="Hot Air Ballon" alt="Image of Hot Air ballon, Experience the city like a local" style="width: 100px; height: 100px;">
        <h4 style="margin: 20px;">CHỌN HƯỚNG ĐI</h4>
      </div>
      <div class="col-md-4 text-center">
        <img class="img-icon" src="{{ asset('/picture/front/fly.png')}}" title="Drink" alt="Enjoy the evenings with new friends you make on the tour " style="width: 100px; height: 100px;">
        <h4 style="margin: 20px; margin-bottom: 100px;">BAY THÔI</h4>
      </div>

  </div>

</div>

<main class="container" >
  @yield('content-section')
</main>
@endsection

