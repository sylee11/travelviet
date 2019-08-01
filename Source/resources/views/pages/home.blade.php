@extends('layouts.app')

@section('content')

<header style="position: relative;">
  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>

  <div class="header-content" style="position: absolute; top:150px;" >
    <div class="header-content-inner" style="font-family: 'Lobster', cursive;
">

      <h1 id="homeHeading" style="font-size: 45px; margin-left: 20%; margin-right: 20%;">Travel Việt - Du Lịch Trong Tầm Tay Bạn</h1>
      <hr>
      <hr align="content" width="20%" color="#3997A6" size="5px" style="padding-bottom: 1.5px;"> 
     {{--  <button  data-target="#demo" class="btn btn-primary  " style="width: 150px; height: 50px; border-radius: 20px; background-color: #3997A6">
      Tìm kiếm địa điểm </button> --}}
      <div style="display: flex;justify-content: center;">
      <form action="{{route('get.list')}}" method="get" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
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
            
            
           <!--  <input type="text" class="typeahead form-control" name="cities_id"  id="city"  placeholder="Tỉnh, thành phố" style="background-color: #467F3E; color: white; border-radius: 10px; height: 40px; width: 180px; margin-bottom: 10px;">
            -->
            <!-- <div class="form-group">
              <input type="text" value="" name="cities_id" id="city" class="form-control input-lg" placeholder="Tỉnh, thành phố"  />
              <div id="cityList">
              </div>
            </div> -->
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

              <button class="btn " type="button"  style="height: 37px; margin-left: 30px; background-color: #3997A6   "> <a class="" href="{{route('google.map')}}"><i class="fas fa-map-marker-alt " style="color: white; " ></i></a>
              </button>
            </div>

            </div>
          </form>
          <!-- <div style="padding-top: 100px;">
            <button class="btn btn-primary"  style="height: 37px;   ">
              <a class="" href="{{route('google.map')}}"><i class="fas fa-map-marker-alt " style="color: white; " ></i></a>
            </button>
          </div> -->


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
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="row">
              
            
            <div>
               <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search" required="" id="inputsearch">
               <div id="searchList"></div>
            </div>
           
            
            <div>
              <button class="btn " type="submit" style="background: #FB8B34; color: white; " id="btnsearch"> <span class="font-weight-bold" >Search </span></button>
            </div>
            </div>
          </form>
        
        </div>
        
      </div>
    </div>

  </div>
</header>
<div class="" style="width: 100%; background-color: #3BB5C9; margin: 0px; color: white;" id="about">
  <div class="row" style="" >
      <div class="col-lg-12 col-lg-offset-2">
        <h2 class="section-heading text-center" style="margin-top: 50px;">PHƯƠNG CHÂM CỦA CHÚNG TÔI
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
<script>
  $(document).ready(function(){

   $('#inputsearch').keyup(function(){ 
    var query = $(this).val();
    if(query != '')
    {
     var _token = $('input[name="_token"]').val();
     $.ajax({
      url:"{{ route('autocomplete.search') }}",
      method:"GET",
      data:{query:query, _token:_token},
      success:function(data){
       $('#searchList').fadeIn();  
       $('#searchList').html(data);
     }
   });
   }
 });

   $(document).on('click', 'li', function(){  
    $('#inputsearch').val($(this).text());  
    $('#searchList').fadeOut();  
  });  

 });
</script>
<main class="container" >
  @yield('content-section')
</main>
@endsection

