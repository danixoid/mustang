@extends('app')

@section('title')
    Поиск автомобилей грузоперевозчиков
@endsection

@section('meta')
    <style>
        .well {
            min-height : 350px;
        }

    </style>
@endsection

@section('content')

<!-- end of container -->
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Поиск</h3>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(array('method' =>'GET','route'=>'truck.list')) !!}

                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('tracker', old('tracker'),old('tracker') != '') !!}
                                Только отслеживаемые
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('legal', old('legal'),old('legal') != '') !!}
                                Только легальные
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('phones', old('phones'),old('phones') != '') !!}
                                Только с телефонами
                            </label>
                        </div>

                        <div class="form-group">
                            {!! Form::label('city', 'Местонахождение') !!}
                            {!! Form::text('city',old('city'),array('class' => 'form-control',
                                'placeholder' => 'Город')) !!}
                        </div>


                        <div class="form-group">

                            {!! Form::label('type_id', 'Тип кузова') !!}

                            <?php
                            $types = App\Models\TruckType::all();
                            $typesArr = [];
                            foreach($types as $type) {

                                preg_match( '/[а-яА-Я\w\d\s\-\"]+/u', $type->description, $match );

                                if(count($match) > 0)
                                    $typesArr[$type->id] = $match[0];
                                else
                                    $typesArr[$type->id] = $type->description;
                            }
                            ?>
                            {!! Form::select('type_id', $typesArr, old('type_id'),
                                array('class' => 'form-control','id' => 'types')) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('min-width', 'Ширина (метров)') !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::number('min_width', old('min_width'), array('class' => 'form-control',
                                    'placeholder' => 'миним.')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::number('max_width', old('max_width'), array('class' => 'form-control',
                                    'placeholder' => 'максим.')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('min_height', 'Высота (метров)') !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::number('min_height', old('min_height'), array('class' => 'form-control',
                                        'placeholder' => 'миним.')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::number('max_height', old('max_height'), array('class' => 'form-control',
                                        'placeholder' => 'максим.')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('min_length', 'Длина (метров)') !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::number('min_length', old('min_length'), array('class' => 'form-control',
                                    'placeholder' => 'миним.')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::number('max_length', old('max_length'), array('class' => 'form-control',
                                    'placeholder' => 'миним.')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('min_length', 'Грузоподъёмность (кг)') !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::number('min_capacity', old('capacity'), array('class' => 'form-control',
                                    'placeholder' => 'миним.')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::number('max_capacity', old('capacity'), array('class' => 'form-control',
                                    'placeholder' => 'максим.')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('min_length', 'Объём (метров куб.)') !!}
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::number('min_volume', old('min_volume'), array('class' => 'form-control',
                                    'placeholder' => 'миним.')) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Form::number('max_volume', old('max_volume'), array('class' => 'form-control',
                                    'placeholder' => 'максим.')) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('paginate', 'Показывать на странице') !!}
                            {!! Form::number('paginate', old('paginate'),
                                array('class' => 'form-control','placeholder' => 'кол-во')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Найти',array('id' => 'search', 'class' => 'btn btn-lg btn-primary')) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-10">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Найдено {{ $trucks->total() }}</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $page = $trucks->currentPage();
                        $i = 1 + ((int)$page - 1) * $trucks->perPage();
                        ?>
                        {!! $trucks->appends(Input::all())->render() !!}

                        <div class="row">
                            @foreach($trucks as $truck)

                                <div class="col-md-4">
                                    <div class="well well-sm">
                                        <?php
                                        $user = $truck->user;
                                        $tracking = $user->tracked()->where('user_id',Auth::user()->id)->first();
                                        ?>

                                        @include('tracking/ajax_form')
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {!! $trucks->render() !!}
                    </div>
                </div>
            </div>
        </div>



@endsection

@section('javascript')

    <script>
        $(document).ready( function () {
            // define lat / long
            if($('#city').val() == '') {
                getCity(50.41667938232422, 80.26166534423828);
            }

            $('.checkbox, #types').on('change', function () {
                $("#search").click();
            });
        });

        function getCity (lat,long)
        {
            $.ajax({
                type: 'GET',
                dataType: "json",
                url: "http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+long+"&sensor=false",
                data: {},
                success: function(data) {
                    $.each( data['results'],function(i, val) {
                        $.each( val['address_components'],function(i, val) {
                            if (val['types'] == "locality,political") {
                                if (val['long_name']!="") {
                                    $('#city').val(val['long_name']);
                                }
                                else {
                                    $('#city').val("Не известно");
                                }
                                console.log(i+", " + val['long_name']);
                                console.log(i+", " + val['types']);
                            }
                        });
                    });
                    console.log('Success');
                },
                error: function () { console.log('error'); }
            });
        }
    </script>
@endsection