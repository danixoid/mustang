@extends('app')

@section('javascript')
    <meta name="_token" content="{{ csrf_token() }}"/>


    <!--JavaScript-->

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry"></script>
    <script>

    var trucks = [];
    var timeout = setTimeout(null);
    

    var mapCenter = new google.maps.LatLng(43.241485, 76.876108);
    var map;
    var content = '';
    var infowindow = null;
    var markerCenter = null;
    var markerTrucks = [];
    var circleRadius = new google.maps.Circle(null);
    var radius = 0;
    var timelong = 0;

    function initialize() {

        var mapOptions = {
            zoom: 13,
            //center: mapCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        myPlace();

        getPositionCenter();

    }


    function getPositionCenter() {


        // Try HTML5 geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                mapCenter = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                content = mapCenter.toString();
                showlog('Мое местоположение!', content)
            }, function () {
                content = 'Геолокация не работает.';
                showlog('Ошибка!', content);
            });
        } else {
            // Browser doesn't support Geolocation
            content = 'К сожалению ваш браузер не поддерживает геолокацию.';
            showlog('Ошибка!', content);
        }

        markerCenter.latLng = mapCenter;

        map.panTo(mapCenter);
    }

    function myPlace() {
        content = content;

        infowindow = new google.maps.InfoWindow({
            content: content
        });

        markerCenter = new google.maps.Marker({
            position: mapCenter,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(markerCenter, 'click', function() {
            if (infowindow) {
                infowindow.close();
            }
            infowindow = new google.maps.InfoWindow({
                content: content
            });
            infowindow.open(map,markerCenter);
        });

        google.maps.event.addListener(markerCenter,'dragend',function(event) {
            mapCenter = event.latLng;
            monitoring();
        });
    }


    function monitoring() {

        clearTimeout(timeout);

        findTrucksHere();

        timeout = setTimeout(findTrucksHere(),timelong);
    }

    function findTrucksHere() {

        radius = parseInt(document.getElementById("radius").value);
        timelong = parseInt(document.getElementById("timelong").value);

        circleRadius.setMap(null);

        circleRadius = new google.maps.Circle({
            strokeColor: '#0000FF',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#0000FF',
            fillOpacity: 0.1,
            center: mapCenter,
            map: map,
            radius: radius
        });

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $.ajax({
            'method' : 'POST',
            'url' : '{{ url('/findtruck') }}',
            'dataType' : 'json',
            'data' : {
                'lat': mapCenter.lat(),
                'long': mapCenter.lng(),
                'radius': radius / 1000
            },
            'success' : function (data) {
                trucks = data;
                showTrucks(trucks);
                drawTableTrucks(trucks);
                //alert(JSON.stringify(trucks));
            },
            'error' : function (error) {
                showlog('Ошибка!', JSON.stringify(error));
            }
        });
        map.panTo(mapCenter);
    }

    
    function showTrucks(trucks) {

        markerTrucks.forEach(function(item, i, arr) {
            item.setMap(null);
        });

        trucks.forEach(function (item, i, arr) {
            
            var truckLatlng = new google.maps.LatLng(item.lat,item.long);

            var aboutTruck = item.truck.user.name + ' ' + item.truck.gos_number + ' ' + item.truck.brand
                    + ' ' + item.truck.seria + '<br />Последнее обновление ' + item.created_at;

            var image = {
                url: 'img/truck_map.png',
                size: new google.maps.Size(50, 32),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(0, 32)
            };

            var shape = {
                coords: [1, 1, 1, 50, 50, 50, 50, 1],
                type: 'poly'
            };

            var markerTruck = new google.maps.Marker({
                position: truckLatlng,
                map: map,
                icon: image,
                shape: shape,
                title: aboutTruck
            });

            google.maps.event.addListener(markerTruck, 'click', function() {
                if (infowindow) {
                    infowindow.close();
                }
                infowindow = new google.maps.InfoWindow({
                    content: aboutTruck
                });
                infowindow.open(map,markerTruck);
            });

            markerTrucks.push(markerTruck);
        });
    }

    function drawTableTrucks (trucks) {

        var tb = document.getElementById("table_trucks");
        var title = 'Ничего не найдено!';
        var str = '';

        if (trucks.length > 0) {
            title = 'Найдено ' + trucks.length + ' грузовиков';

            trucks.forEach(function (item, i, arr) {
                str += '<tr>';
                str += '<td>' + (i+++1) + '</td>';
                str += '<td>' + item.truck.user.surname + ' ' + item.truck.user.name + ' '
                    + item.truck.user.father + '</td>';
                str += '<td>' + item.truck.gos_number + ' ' + item.truck.brand + ' '
                    + item.truck.seria + ' ' + '</td>';
                str += '<td></td>';
                str += '</tr>';
            });
        }

        tb.innerHTML = '<div class="panel-heading">' + title + '</div>' +
        '<table class="table table-striped table-hover">' +
        '<tr>' +
        '<th>№ п/п</th><th>Водитель</th><th>Автомобиль</th><th>Статус</th>' +
        '</tr>' + str +
        '</table>';
    }

    function showlog(title,text) {

        var logplace = document.getElementById("logplace");

        logplace.innerHTML =
            '<div class="panel panel-info"><div class="panel-heading">' +
            '<h3 class="panel-title">' +
            title +
            '</h3></div><div class="panel-body">' +
            text +
            '</div></div>';
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
    
@endsection


@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Поиск грузовика в радиусе</div>

        <div class="panel-body">

            <div class="row">
                <div class="col-md-9">
                    <div id="map-canvas" style="height:400px"></div>
                </div>
                <div class="col-md-3">
                    <div id="logplace" class="form-group"></div>
                    <div class="form-group">
                        <label for="radius">Искать в радиусе (в метрах)</label>
                        <input type="number" id="radius" placeholder="Радиус в метрах"
                            onkeyup="monitoring();" class="form-control" value="4000"/>
                    </div>
                    <div class="form-group">
                        <label for="radius">Обновление (в секундах)</label>
                        <input type="number" id="timelong" placeholder="в секундах"
                            onkeyup="monitoring();" class="form-control" value="60"/>
                    </div>
                    <button class="btn btn-danger" onclick="monitoring();">Обновить</button>
                    <button class="btn btn-primary" onclick="getPositionCenter();">Моя геолокация</button>
                </div>
            </div>
        </div>
	</div>
    <div class="col-md-offset-1 col-md-10">
        <div id="table_trucks" class="panel panel-default"></div>
    </div>
</div>
@endsection