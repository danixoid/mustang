@extends('app')

@section('javascript')

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry"></script>
<script>

    var trucks = [];

    

    var myLatlng = new google.maps.LatLng(47.274398, 65.775136);
    var map;
    
    function initialize() {

        var mapOptions = {
          zoom: 13,
          //center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          // Try HTML5 geolocation
            if(navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                var contentString = myLatlng.toString();

                var infowindow = new google.maps.InfoWindow({
                  content: contentString
                });

                var marker = new google.maps.Marker({
                  position: myLatlng,
                  map: map,
                  title: 'Вот такая фигня'
                });

                google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open(map,marker);
                });
                
                for (i = 0; i < 5; i++) {
                    trucks.push({
                       truck_id : i,
                       user_id : i,
                       lat : randomCoord(myLatlng.lat()),
                       long : randomCoord(myLatlng.lng()),
                       gos_num : (Math.random()*10 | 0),
                       content : 'Вот такая фигня №' + i,

                    });
                }
                
                randomTrucks(trucks);
                
                map.setCenter(myLatlng);
              }, function() {
                handleNoGeolocation(true);
              });
            } else {
              // Browser doesn't support Geolocation
              handleNoGeolocation(false);
            }
          
            
    }
          
    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
          var content = 'Ошибка: Геолокация не пашет.';
        } else {
          var content = 'Ошибка, к сожалению ваш браузер не поддерживает геолокацию.';
        }

        var options = {
          map: map,
          position: myLatlng,
          content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
    }


    function randomCoord(l) {
        var min = l - 0.02;
        var max = l + 0.02;
        return (Math.random()*(max - min) + min);
    }
    
    function randomTrucks(trucks) {
        
        trucks.forEach(function (item, i, arr) {
            
            var truckLatlng = new google.maps.LatLng(item.lat,item.long);
    
            var markerTruck = new google.maps.Marker({
                position: truckLatlng,
                map: map,
                title: item.gos_num + ' ' + item.content,
            });
            
            var infowindow = new google.maps.InfoWindow({
              content: item.gos_num + ' ' + item.content
            });
            
            google.maps.event.addListener(markerTruck, 'click', function() {
                infowindow.open(map,markerTruck);
            });
        });

        
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
    
@endsection


@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Home</div>

        <div class="panel-body">

            <div class="row">
                <div class="col-md-9">
                    <div id="map-canvas" style="height:400px"></div>
                </div>
                <div class="col-md-3">

                </div>
            </div>
        </div>
	</div>
</div>
@endsection