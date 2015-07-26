@extends('app')

@section('title')
    Отслеживание по карте
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

        table>tbody>tr:hover {
            cursor : pointer;
            background-color : #5bc0de;
        }

    </style>
@endsection

@section('javascript')
    <!--JavaScript-->

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=geometry"></script>
    <script>

    var truck = {};
    var timeout = setTimeout(null);
    var lat = {{ Auth::user()->track->lat ?: 50.41667938232422 }};
    var lng = {{ Auth::user()->track->lng ?: 80.26166534423828 }};

    var mapCenter = new google.maps.LatLng(lat, lng);
    var map;
    var host = '{!! url('/') !!}';
    var content = '';
    var infowindow = null;
    var markerTrucks = [];
    var timelong = 10;

    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    function initialize() {

        var mapOptions = {
            zoom: 10,
            center: mapCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };


        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);


        google.maps.event.addListener(map, 'click',
                function ()
                {
                    map.setZoom(10);

                    if (infowindow) {
                        infowindow.close();
                    }

                    $("#logplace").html('');
                }
        );

        monitoring();
    }

    function monitoring() {

        clearTimeout(timeout);

        timeout = setTimeout(function() {
                @foreach ($trackers as $tracked)
                    findTruck({{ $tracked->tracked->id }});
                @endforeach
            },timelong);
    }

    function findTruck(id) {

        $.ajax({
            'method' : 'POST',
            'url' : host + '/json/' + id + '/truck',
            'dataType' : 'json',
            //'data' : {},
            'success' : function (data) {
                truck = data;
                //alert(JSON.stringify(trucks));
                showTruck(truck);
            },
            'error' : function (error) {
                showlog('Ошибка!', JSON.stringify(error));
            }
        });
    }

    function showTruck(item) {

        var truckLatlng = new google.maps.LatLng(item.track.lat,item.track.lng);

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

        markerTrucks[item.id] = new google.maps.Marker({
            position: truckLatlng,
            map: map,
            icon: image,
            shape: shape,
            title: title
        });

        var showWindow = function()
        {
            if (infowindow) {
                infowindow.close();
            }

            infowindow = new google.maps.InfoWindow({
                content: title
            });

            infowindow.open(map,markerTrucks[item.id]);

            $.get(host + "/tracking/" + item.id + "/ajax_form",
                function( data ) {
                    showlog(title,data);
                }
            );

            map.panTo(truckLatlng);
            map.setZoom(13);
        };

        $("#truck_" + item.id).on('click',showWindow);

        google.maps.event.addListener(markerTrucks[item.id], 'click', showWindow);

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
            {!! link_to_route('truck.list','Добавить для отслеживания',
                array('class' => 'btn btn-link')) !!}

            <table class="table">
                <thead>
                    <tr>
                        <th>Водитель</th>
                        <th>Марка</th>
                        <th>Гос.номер</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trackers as $tracking)
                        <?php
                        $user = $tracking->tracked;
                        $truck = $user->truck;
                        ?>
                            <tr id="truck_{{ $user->id }}">
                                <td>{{ $user->surname }} {{ $user->name }}</td>
                                <td>{{ $truck->brand }} / {{ $truck->seria }}</td>
                                <td>{{ $truck->gos_number }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection