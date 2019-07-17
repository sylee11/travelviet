  <!-- <!DOCTYPE html>
  <html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
      * element that contains the map. */
      #map {
        height: 600px;
      }
      /* Optional: Makes the sample page fill the window. */
      
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      var place = <?php print_r(json_encode($place)) ?>;
      // window.onload=function(){console.log(place);}
      // for (var i = 0; i < 3; i++) {
      //      var latvalue = place.
    //   //    }   
    function initMap() {
    //     $.each( place, function( index, value ){
    //     var latvalue= value.lat,
    //     var longvalue= value.longt,
    // });
    //     var uluru ={
    //       lat: latvalue,
    //       lng: longvalue
    //     };
    map = new google.maps.Map(document.getElementById('map'), {
     center: new google.maps.LatLng(2.8,-187.3),
     zoom: 16,
   });
    
      // var marker = new google.maps.Marker({
      //   position: uluru,
      //   map: map
      // });
      

      infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            // var marker = new google.maps.Marker({
            //   position: pos,
            //   map: map
            // });
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }
      
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
          'Error: The Geolocation service failed.' :
          'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxqyb5cmgcv7j9hY-GcPZYcNQlwyfWaT0&callback=initMap">
  </script>
</body>
</html>
-->

<!DOCTYPE html>
<html>
<head>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!--  <script src="https://maps.google.com/maps/api/js"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxqyb5cmgcv7j9hY-GcPZYcNQlwyfWaT0&callback=initMap">
</script>

<style type="text/css">
  #map {
    border:1px solid red;

    height: 600px;
  }
</style>


</head>
<body>

  <div id="map"></div>
  <script type="text/javascript">
   var map, infoWindow;
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
              zoom:16
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


