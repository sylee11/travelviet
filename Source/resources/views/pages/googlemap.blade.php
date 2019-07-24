

@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
  <title>Googlemap</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!--  <script src="https://maps.google.com/maps/api/js"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxqyb5cmgcv7j9hY-GcPZYcNQlwyfWaT0&callback=initMap">
</script>

<style type="text/css">
  #map {
    border:1px solid red;
    height: 500px;
   
  }
</style>


</head>
<body>

  <div id="map" style="height: 500px;top:70px;border:1px solid red;  "></div>
  <script type="text/javascript">
   var map, infoWindow;
   function initMap(){
     map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 10,
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
             
             click: function(e) {
              alert('Vị trí của bạn');
            }
            
          });

            $.each( place, function( index, value ){
              marker.addMarker({
                lat: value.lat,
                lng: value.longt,
                title: value.address,

                click: function(e) {
                  alert(value.name +','+value.address);
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