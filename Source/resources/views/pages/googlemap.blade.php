

@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Googlemap</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-rW15K4v7WHlCWmnCYMLzyR0pU1cPpeI&libraries=places&callback=initMap"async defer></script>

<style type="text/css">
  #map {
    border:1px solid red;
    height: 500px; 
  }
  
</style>


</head>
<body>
  <div>
    
    <div id="map" style="height: 500px;top:60px;border:1px solid red;  "></div>
  </div>
   
  <script type="text/javascript">
   var map, infoWindow;
   var markers = [];
   function initMap(){
     map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 16,
    });
     infoWindow = new google.maps.InfoWindow;
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            
             var place = <?php print_r(json_encode($place)) ?>;
             var marker = new GMaps({
              el: '#map',
              center: pos,
              zoom:12
            });
            
            marker.addMarker({
             position: pos,
             title:'vị trí của bạn',
             infoWindow: {
              content: 'vị trí của bạn'
            }  
          });
            $.each( place, function( index, value ){
              marker.addMarker({
                lat: value.lat,
                lng: value.longt,
                title: value.name,
                infoWindow: {
                  content: 'Tên địa điểm :'+value.name+'<br>Địa chỉ :'+value.address
                }       
              });
             });
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }
      
    </script>
  </body>
  </html>

@endsection