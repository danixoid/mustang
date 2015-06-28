@extends('app')


@section('javascript')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>

        function initialize() {

            var defaultBounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(-33.8902, 151.1759),
                new google.maps.LatLng(-33.8474, 151.2631));

            var input = document.getElementById('searchTextField');
            var options = {
                bounds: defaultBounds,
                types: ['geocode']
            };

            var inputА = document.getElementById('from');
            var inputB = document.getElementById('to');

            google.maps.event.addDomListener(inputА, 'keydown', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });

            google.maps.event.addDomListener(inputB, 'keydown', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });

            var autocompA = new google.maps.places.Autocomplete(inputА,options);
            var autocompB = new google.maps.places.Autocomplete(inputB,options);

            google.maps.event.addListener(autocompA, 'place_changed', function() {
                return false;
            });

            google.maps.event.addListener(autocompB, 'place_changed', function() {
                return false;
            });
        }

         google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@endsection

@section('content')

    {!! link_to_route('cargo.create','Добавить',[],['class' => 'pull-right btn btn-link']); !!}
    {!! link_to_route('cargo.list','Список',[],['class' => 'pull-right btn btn-link']); !!}

    <div class="row">

        <div class="col-sm-2">
        {!! link_to_route('cargo.edit','Правка',['id' => $cargo->id],['class' => 'btn btn-link']); !!}
        </div>
        <div class="col-sm-1">{{ $cargo->capacity }}</div>
        <div class="col-sm-1">{{ $cargo->weight }}</div>
        <div class="col-sm-1">{{ $cargo->budget }}</div>
        <div class="col-sm-1">{{ $cargo->user->name }}</div>
        <div class="col-sm-3">{{ $cargo->load }}</div>
        <div class="col-sm-3">{{ $cargo->descriptions }}</div>

    </div>

@endsection