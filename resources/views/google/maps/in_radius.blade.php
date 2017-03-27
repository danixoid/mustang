@extends('app')

@section('title')
    Поиск грузоперевозчиков по карте
@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>

    <style>

        #map-canvas {
            height: 500px;
        }

        #form-inline {
            margin: 4px;
            padding: 4px;
            background-color: #FFFFFF;
        }

    </style>
@endsection

@section('javascript')
    <!--JavaScript-->

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry&project=794016713921&key=AIzaSyB4uLQ4JnafmoA030S27XXXeGm6-6Z8pOg"></script>
    <script>

    var trucks = [];
    var timeout = setTimeout(null);
    var lat = {{ Auth::user()->track ? Auth::user()->track->lat : 50.41667938232422 }};
    var lng = {{ Auth::user()->track ? Auth::user()->track->lng : 80.26166534423828 }};

    var mapCenter = new google.maps.LatLng(lat, lng);
    var map;
    var host = '{!! url('/') !!}';
    var content = '';
    var infowindow = null;
    var markerCenter = new google.maps.Marker(null);
    var markerTrucks = [];
    var circleRadius = new google.maps.Circle(null);
    var radius = 0;
    var timelong = 0;

    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    function initialize() {

        var mapOptions = {
            zoom: 13,
            //center: mapCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };


        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        // Create a div to hold everything else
        var controlDiv = document.createElement('DIV');
        controlDiv.id = "form-inline";

        // Create a label1
        var controlLabelRadius = document.createElement('label');
        controlLabelRadius.innerHTML = 'Радиус (в м)';
        controlLabelRadius.setAttribute("for","radius");

        // Create an input field1
        var controlInputRadius = document.createElement('input');
        controlInputRadius.id = "radius";
        controlInputRadius.type = "number";
        controlInputRadius.value = "4000";
        controlInputRadius.setAttribute('placeholder', 'Радиус в метрах');
        controlInputRadius.setAttribute('onkeyup', 'monitoring();');


        // Create a label2
        var controlLabelRefresh = document.createElement('label');
        controlLabelRefresh.innerHTML = 'Обновление (в сек)!';
        controlLabelRefresh.setAttribute("for","timelong");

        // Create an input field2
        var controlInputRefresh = document.createElement('input');
        controlInputRefresh.id = "timelong";
        controlInputRefresh.type = "number";
        controlInputRefresh.value = "60";
        controlInputRefresh.setAttribute('placeholder', 'в секундах');
        controlInputRefresh.setAttribute('onkeyup', 'monitoring();');

        // Create a button to send the information
        var controlButtonRefresh = document.createElement('button');
        controlButtonRefresh.innerHTML = 'Обновить';

        var controlButtonGeo = document.createElement('button');
        controlButtonGeo.innerHTML = 'Сброс';

        // Append everything to the wrapper div
        controlDiv.appendChild(controlLabelRadius);
        controlDiv.appendChild(controlInputRadius);
        controlDiv.appendChild(controlLabelRefresh);
        controlDiv.appendChild(controlInputRefresh);
        controlDiv.appendChild(controlButtonRefresh);
        controlDiv.appendChild(controlButtonGeo);

        google.maps.event.addDomListener(controlButtonRefresh, 'click', monitoring);
        google.maps.event.addDomListener(controlButtonGeo, 'click', getPositionCenter);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(controlDiv);

        getPositionCenter();

        google.maps.event.addListener(map, 'dragend', findTrucksHere);
        google.maps.event.addListener(map, 'idle', findTrucksHere);
        google.maps.event.addListener(map, 'zoom_changed', findTrucksHere);
    }


    function getPositionCenter() {


        // Try HTML5 geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {

                lat = position.coords.latitude;
                lng = position.coords.longitude;

                $.ajax({
                    'url' : host + "/track/" + lat + "/" + lng + "/store",
                    'method' : "POST",
                    'success' : function(data)
                    {
                        mapCenter = new google.maps.LatLng(lat, lng);
                        content = 'Мое местоположение: ' + mapCenter.toString();
                        markerCenter.setPosition(mapCenter);
                        showlog('Мое местоположение', content)
                    },
                    'error': function()
                    {
                        alert("Ошибка! Не возможно пересохранить ваше местоположение");
                    }
                });

            }, function () {
                content = 'Геолокация не работает.';
                showlog('Ошибка!', content);
            });
        } else {
            // Browser doesn't support Geolocation
            content = 'К сожалению ваш браузер не поддерживает геолокацию.';
            showlog('Ошибка!', content);
        }


        map.panTo(mapCenter);
    }


    function monitoring() {

        clearTimeout(timeout);

        timeout = setTimeout(findTrucksHere(),timelong);
    }

    function findTrucksHere() {

        mapCenter = map.getCenter();

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

        $.ajax({
            'method' : 'POST',
            'url' : '{{ route('json.trucks.radius') }}',
            'dataType' : 'json',
            'data' : {
                'lat': mapCenter.lat(),
                'lng': mapCenter.lng(),
                'radius': radius / 1000
            },
            'success' : function (data) {
                trucks = data;
                //alert(JSON.stringify(trucks));
                showTrucks(trucks);
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

        if (trucks.length > 0)
        {
            $('#table_trucks .panel-heading').text('Найдено ' + trucks.length + ' грузовиков');
        }
        else
        {
            $('#table_trucks .panel-heading').text('Ничего не найдено!');
            $('#table_trucks .panel-body table>tbody').text('')

            return false;
        }

        $('#table_trucks .panel-body table>tbody').html('');

        trucks.forEach(function (item, i, arr) {

            var truckLatlng = new google.maps.LatLng(item.track.lat,item.track.lng);
            /*
            var imgSrc = item.picture == null
                    ? host + '/img/NO_FACE.png'
                    : host + '/file/' + item.picture.id;

            var phones = [];

            for (var i = 0; i < item.phones.length; i++) {
                phones.push(item.phones[i].phone_number);
            }

            var status_desc = item.truck.status == null ? 'Свободен'
                    : item.truck.status.description;


            var aboutTruck =
                    '<div class="container-fluid">' +
                    '<div class="row">' +
                    '<div class="col-xs-3">' +
                    '<input type="image" src="' + imgSrc + '" height="80px" />' +
                    '</div>' +
                    '<div class="col-xs-9">' +
                    '<table class="table">' +
                    '<tr><th colspan="2"><h4><a href="' + host + '/user/' +
                    item.id + '/show">' + item.name +
                    '</a>' + '</h4></th></tr>' +
                    '<tr><th>Статус</th><td>' + status_desc + '</td></tr>' +
                    '<tr><th>Марка</th><td>' + item.truck.brand + ' ' + item.truck.seria + '</td></tr>' +
                    '<tr><th>Гос.номер</th><td>' + item.truck.gos_number + '</td></tr>' +
                    '<tr><th>Телефоны</th><td>' + phones.join() + '</td></tr>' +
                    '<tr><th>Простаивает с </th><td>' + item.track.created_at + '</td></tr>' +
                    '</table>' +
                    '</div>' +
                    '</div>' +
                    '</div>';*/

            var truck_status = item.truck.status == null ? 'TRUCK_FREE' : item.truck.status.code;
            var title = item.truck.gos_number + ' ' + item.truck.brand + ' / ' + item.truck.seria;

            var image = {
                url: host + '/img/' + truck_status + '.png',
                size: new google.maps.Size(50, 64),
                origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(25, 64)
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
                title: title
            });

            var showWindow = function() {
                if (infowindow) {
                    infowindow.close();
                }
                infowindow = new google.maps.InfoWindow({
                    content: title
                });
                infowindow.open(map,markerTruck);

                $.get(host + "/tracking/" + item.id + "/ajax_form",
                    function( data ) {
                        showlog(title,data);
                    }
                );
            };

            var TDs = '<td>' + item.surname + ' ' + item.name + '</td>' +
                    '<td>' + item.truck.brand + ' ' + item.truck.seria + '</td>' +
                    '<td>' + item.truck.gos_number + '</td>';

            jQuery('<tr />', {
                html: TDs,
                css : {"cursor" : "pointer"},
                click : showWindow
            }).appendTo('#table_trucks .panel-body table>tbody');

            google.maps.event.addListener(markerTruck, 'click', showWindow);

            markerTrucks.push(markerTruck);
        });
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


    <div class="row">

        <div class="col-md-7">
            <div id="map-canvas"></div>
        </div>

        <div id="logplace" class="col-md-5"></div>

        <div class="col-md-5">
            <div id="table_trucks" class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Водитель</th>
                                <th>Марка</th>
                                <th>Гос.номер</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection