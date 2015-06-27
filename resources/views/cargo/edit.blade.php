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
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Погрузка {{ $cargo != null ? ' / ' . $cargo->load : ''  }}</div>

                    <div class="panel-body">

                        @if ($cargo != null)
                            {!! Form::model($cargo, array('route' =>
                                array('cargo.update', $cargo->id),
                                'method' => 'POST','class' => 'form form-horizontal')) !!}
                        @else
                            {!! Form::open(array('route' => array('cargo.update', -1),
                                'method' => 'POST','class' => 'form form-horizontal')) !!}
                        @endif
                            <div class="form-group">
                                {!! Form::label('load', 'Наименование груза',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-6">
                                    {!! Form::text('load', @$load, array('class' => 'form-control',
                                        'placeholder' => 'Щебень, Мебель, Оборудование')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('from', 'Пункт погрузки',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-6">
                                    {!! Form::text('from', @$from, array('class' => 'form-control',
                                        'id' => 'from' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('to', 'Пункт разгрузки',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-6">
                                    {!! Form::text('to', @$to, array('class' => 'form-control',
                                        'id' => 'to' )) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('capacity', 'Объём груза (в м куб)',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-2">
                                    {!! Form::number('capacity', @$capacity, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('weight', 'Вес груза (в кг)',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-2">
                                    {!! Form::number('weight', @$weight, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('weight', 'Бюджет (в тенге)',
                                    array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-2">
                                    {!! Form::number('budget', @$budget, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Описание груза',
                                array('class' => 'col-md-4 control-label')) !!}
                                <div class="col-md-6">
                                    {!! Form::textarea('descriptions', @$description, array('class' => 'form-control')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    {!! Form::submit('Сохранить',array("class" => "btn btn-primary")) !!}
                                </div>
                            </div>


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection