<?php
include('config.php');
//include('libraries/geocode.php');
include('helpers/mapHelper.php');
include('memory.php');

$APIkey = 'AIzaSyDUmITZVSRPYttrgNz6W5SJbQZa-SkndZ0';


$zip = '66105';

// get gps coords of specific zipcode form csv file
$zipcodecoords = getZipcodeCoords($zip, 'files/zipcodeCoords.csv', ',');
$latitude = $zipcodecoords["LAT"];
$longitude = $zipcodecoords['LNG'];

// create list of all coords for addresses matching zipcode
 
$maplist = makeMapList($list, $zip);
// encode list to json 
$jsoncoords = json_encode($maplist);
echo $jsoncoords;
echo 'Peak Memory: ';
echo_peak_memory_usage();



?>




<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 400px;
        width: 800px;
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $latitude ?>, lng: <?php echo $longitude ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: <?php echo $latitude ?>, lng: <?php echo $longitude ?>}
        });
        
       
        setMarkers(map);
       
      }
      var coordlist = <?php echo $jsoncoords ?>;
      
      
      function setMarkers(map){ 
          for(var i =0; i < coordlist.length - 1; i++){ 
              console.log(coordlist[i]['lat']);
            if(!(coordlist[i]['lat'] === null)){             
                new google.maps.Marker({
                position: {lat: coordlist[i]['lat'] , lng: coordlist[i]['lng']},
                label: 'i',
                map: map         
                });
            }
        }
      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $APIkey;?>&callback=initMap">
    </script>

    
  </body>
</html>