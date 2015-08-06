@extends('app')

@section('title')
    Добавление автомобиля грузоперевозчика {{ $user->surname }} {{ $user->name }}
@endsection

@section('content')

    {!! Form::open(array('route' => array('truck.store',$user->id),
        'method' => 'POST','class' => 'form form-horizontal')) !!}

    <!-- TRUCK UPDATE-->
    <div class="form-group">
        {!! Form::label('brand', 'Марка',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('brand', @$brand, array('class' => 'form-control',
            'placeholder' => 'Пример: Мерцедес-Бенц')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('seria', 'Серия',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('seria', @$seria, array('class' => 'form-control',
            'placeholder' => 'Пример: C220')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">

        {!! Form::label('truck_type_id', 'Тип кузова',
        array('class' => 'col-md-4 control-label')) !!}

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
            {!! Form::select('truck_type_id', $typesArr,
            @$track_type_id, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>


    <div class="form-group">
        {!! Form::label('country_id', 'Страна регистрации',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            <?php
            $countries = App\Models\Country::all();
            $countryArr = [];

            foreach($countries as $country) {
                $countryArr[$country->id] = $country->code
                        . ' - ' . $country->name;
            }
            ?>
            {!! Form::select('country_id', $countryArr,
            @$country_id, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('gos_number', 'Гос.номер',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('gos_number', @$gos_number, array('class' => 'form-control',
            'placeholder' => 'Пример: 16KZ540')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('width', 'Ширина',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('width', @$width, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('width', 'метров',
            array('class' => 'control-label')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('height', 'Высота',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('height', @$width, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('height', 'метров',
            array('class' => 'control-label')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('length', 'Длина',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('length', @$width, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('length', 'метров',
            array('class' => 'control-label')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('capacity', 'Грузоподъёмность',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('capacity', @$capacity, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('capacity', 'кг',
            array('class' => 'control-label')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('volume', 'Объём',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('volume', @$volume, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('volume', 'метров кубических',
            array('class' => 'control-label')) !!}
        </div>

    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            {!! Form::submit('Сохранить',array('class' => 'btn btn-primary')) !!}

            {!! link_to_route('user.show','Назад',array('id' => $user->id),array('class' => 'btn btn-link')) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection