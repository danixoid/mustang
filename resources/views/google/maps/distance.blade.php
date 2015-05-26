@extends('app')

@section('javascript')

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>

        var rendererOptions = {
          draggable: false
        };
        var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
        var directionsService = new google.maps.DirectionsService();
        var map;
        var myLatlng = new google.maps.LatLng(47.274398, 65.775136);
        var inputА;
        var inputB;
          
        function initialize() {

          var mapOptions = {
            zoom: 4,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
          };
          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
          directionsDisplay.setMap(map);
          //directionsDisplay.setPanel(document.getElementById('directionsPanel'));

          google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
            computeTotalDistance(directionsDisplay.getDirections());
          });
          
          inputА = document.getElementById('From');
          inputB = document.getElementById('To');

          var autocompA = new google.maps.places.Autocomplete(inputА,{ types: ['geocode'] });
          var autocompB = new google.maps.places.Autocomplete(inputB,{ types: ['geocode'] });
          
          google.maps.event.addListener(autocompA, 'place_changed', function() {
            calcRoute()
          });
          
          google.maps.event.addListener(autocompB, 'place_changed', function() {
            calcRoute();
          });

        }

        function calcRoute() {
          
          var waypts = [];
          var inputArray = document.getElementsByName('point');
          for (var i = 0; i < inputArray.length; i++) {
            //alert(inputArray[i].value);
            waypts.push({
              location:inputArray[i].value,
              stopover:true
            });
          }
          
          var request = {
            origin: inputА.value,
            destination: inputB.value,
            waypoints: waypts,
            travelMode: google.maps.TravelMode["DRIVING"],
            unitSystem: google.maps.UnitSystem.METRIC,
            avoidHighways: false,
            avoidTolls: false
          };
          directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
              directionsDisplay.setDirections(response);
            }
          });
        }

        function computeTotalDistance(result) {
          var total = 0;
          var myroute = result.routes[0];
          for (var i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
          }
          total = (total - total % 1000.0) / 1000.0;
          document.getElementById('total').innerHTML = 'Полная дистанция: <span>' + total + ' км</span>';
        }

        function addWayPoint() {
            var waypoint = document.createElement("div");
            var inputpoint = document.createElement("input");
            var labelpoint = document.createElement("label");
            var delpoint = document.createElement("a");
            var glyphdel = document.createElement("i");
            var topoint = document.getElementById("ToFormGroup");
            var parent = topoint.parentNode;
            
            waypoint.appendChild(labelpoint);
            waypoint.appendChild(delpoint);
            waypoint.appendChild(inputpoint);
            waypoint.id = "input_" + Math.floor((Math.random() * 1000) + 1);
            
            parent.insertBefore(waypoint,topoint);
            
            labelpoint.innerHTML = "Через пункт";
            glyphdel.className = "glyphicon glyphicon-remove";
            delpoint.className = "pull-right";
            delpoint.setAttribute('href','javascript:deleteWayPoint("' + waypoint.id + '");');
            delpoint.appendChild(glyphdel);
            waypoint.className = "form-group";
            inputpoint.className = "form-control";
            inputpoint.setAttribute('name','point');
            
            
            var autocomp = new google.maps.places.Autocomplete(inputpoint,{ types: ['geocode'] });
            
            google.maps.event.addListener(autocomp, 'place_changed', function() {
              calcRoute();
            });
        }
        
        function deleteWayPoint(id) {
            var input = document.getElementById(id);
            var parent = input.parentNode;
            parent.removeChild(input);
            calcRoute();
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
    
@endsection


@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Home</div>

        <div class="panel-body">

            <div class="row" style="height:400px">
                <div class="col-md-9" id="map-canvas" style="height:100%"></div>
                <div class="col-md-3">
                    <div id="Distance" name="Distance" class="group">
                        <div class="form-group" id="FromFormGroup">
                            <label for="From">Пункт загрузки:</label>
                            <input type="text" id="From" name="From" class="form-control"/>
                        </div>
                        <div class="form-group" id="ToFormGroup">
                            <label for="To">Пункт разгрузки:</label>
                            <input type="text" id="To" name="To" class="form-control"/>
                        </div>
                        <button class="btn btn-primary" onclick="calcRoute();return false;">Расчитать</button>
                        <button class="btn btn-primary" onclick="addWayPoint();return false;">Через пункты</button>
                    </div>
                    <div id="total"></div>
                    <div id="directionsPanel" style="height:100%"></div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection