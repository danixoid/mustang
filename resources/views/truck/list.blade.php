@extends('app')


@section('content')


    <div class="container">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Поиск грузоперевозчиков</h3>
            </div>
            <div class="panel-body">

                {!! Form::open(array('method' =>'POST','route'=>'truck.list',
                    'class' => 'form-horizontal')) !!}

                <div class="form-group">
                    {!! Form::label('city', 'Город',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-4">
                        {!! Form::text('city',old('city'),array('class' => 'form-control',
                        'placeholder' => 'Город')) !!}
                    </div>
                </div>


                <div class="form-group">

                    {!! Form::label('type_id', 'Тип кузова',
                    array('class' => 'col-md-3 control-label')) !!}

                    <div class="col-md-4">
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
                        {!! Form::select('type_id', $typesArr, old('type_id'), array('class' => 'form-control')) !!}
                    </div>
                    <div class="col-md-2"></div>
                </div>


                <div class="form-group">
                    {!! Form::label('min-width', 'Ширина',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-1">
                        {!! Form::number('min_width', old('min_width'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::number('max_width', old('max_width'), array('class' => 'form-control',
                        'placeholder' => 'максим.')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('max_width', 'метров',
                        array('class' => 'control-label')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('min_height', 'Высота',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-1">
                        {!! Form::number('min_height', old('min_height'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::number('max_height', old('max_height'), array('class' => 'form-control',
                        'placeholder' => 'максим.')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('max_height', 'метров',
                        array('class' => 'control-label')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('min_length', 'Длина',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-1">
                        {!! Form::number('min_length', old('min_length'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::number('max_length', old('max_length'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('max_length', 'метров',
                        array('class' => 'control-label')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('min_capacity', 'Грузоподъёмность',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-1">
                        {!! Form::number('min_capacity', old('capacity'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::number('max_capacity', old('capacity'), array('class' => 'form-control',
                        'placeholder' => 'максим.')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('max_capacity', 'кг',
                        array('class' => 'control-label')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('min_volume', 'Объём',
                    array('class' => 'col-md-3 control-label')) !!}
                    <div class="col-md-1">
                        {!! Form::number('min_volume', old('min_volume'), array('class' => 'form-control',
                        'placeholder' => 'миним.')) !!}
                    </div>
                    <div class="col-md-1">
                        {!! Form::number('max_volume', old('max_volume'), array('class' => 'form-control',
                        'placeholder' => 'максим.')) !!}
                    </div>
                    <div class="col-md-2">
                        {!! Form::label('volume', 'метров кубических',
                        array('class' => 'control-label')) !!}
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-4">
                        {!! Form::submit('Найти',array('class' => 'btn btn-lg btn-primary')) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>




    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>Водитель</th>
            <th>Марка и серия</th>
            <th>Гос.номер</th>
            <th>Тип кузова</th>
            <th>Ширина</th>
            <th>Длина</th>
            <th>Высота</th>
            <th>Грузоподъёмность</th>
            <th>Объём</th>
            <th></th>
        </tr>

        <?php
            $page = $trucks->currentPage();
            $i = 1 + ((int)$page - 1) * $trucks->perPage();
        ?>

        @foreach($trucks as $truck)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    {{ $truck->user->surname }} {{ $truck->user->name }} {{ $truck->user->father }}
                    {!! link_to_route('user.show','[Профиль]',$truck->user->id) !!}
                </td>
                <td>{{ $truck->brand }} {{ $truck->seria }}</td>
                <td>{{ $truck->gos_number }}</td>
                <td>
                    <?php
                        $type_name = [];
                        preg_match( '/[а-яА-Я\w\d\s\-\"]+/u', $truck->type->description, $type_name );
                    ?>
                    {{ $type_name[0] }}

                </td>
                <td>{{ $truck->width }}</td>
                <td>{{ $truck->length }}</td>
                <td>{{ $truck->height }}</td>
                <td>{{ $truck->capacity }}</td>
                <td>{{ $truck->volume }}</td>
                <td>
                    @if (Auth::user()->is_admin == 1)
                        {!! Form::model($truck,array('route' => array('truck.destroy',$truck->id),
                            'class' => 'form-inline', 'method' => 'POST'))!!}
                        {!! link_to_route('truck.show','Просмотр',array('id' => $truck->id),
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::submit('Удалить',
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

    {!! $trucks->render() !!}

@endsection

@section('javascript')

    <script>
        $(document).ready( function () {
            // define lat / long
            getCity(50.41667938232422,80.26166534423828);
        });

        function getCity (lat,long)
        {
            $.ajax({
                type: 'GET',
                dataType: "json",
                url: "http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+long+"&sensor=false",
                data: {},
                success: function(data) {
                    $('#city').html(data);
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