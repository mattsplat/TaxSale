<?php
$APIkey = 'AIzaSyDUmITZVSRPYttrgNz6W5SJbQZa-SkndZ0';

// get gps coords of specific zipcode form csv file
$zipcodecoords = getZipcodeCoords($zip, 'files/zipcodeCoords.csv', ',');
$latitude = $zipcodecoords["LAT"];
$longitude = $zipcodecoords['LNG'];

// create list of all coords for addresses matching zipcode 
$maplist = makeMapList($list, $zip);
// encode list to json 
$jsoncoords = json_encode($maplist);
?>


    <div id="map" style=""></div>
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
                    var marker = new google.maps.Marker({
                    position: {lat: coordlist[i]['lat'] , lng: coordlist[i]['lng']},
                    label: coordlist[i]['type'],
                    map: map         
                    });
                }
                var link = '<a href="property.php?id='+coordlist[i]['id']+'" >';
                var message =  link + coordlist[i]['address'] + '</a><br> <p style="color: black;">$'+ coordlist[i]['price'] + '</p>'  ;

                addInfoWindow(marker, message);
            }
        }
        function addInfoWindow(marker, message) {

            var infoWindow = new google.maps.InfoWindow({
                content: message
            });

            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });
        }   
            
        
        
       

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $APIkey;?>&callback=initMap">
    </script>