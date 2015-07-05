@extends('app')

@section('content')

    <div class="form-horizontal">
        <div class="form-group">

            {!! Form::label('picture', 'Фото',
                array('class' => 'col-md-4 control-label')) !!}

            <div class="col-sm-6">

                @if ($truck->picture != null)
                    <input type="image" src="{{ route('file.show',$truck->picture->id) }}" height="80px" />
                @else
                    Нет изображения
                @endif

                {!! Form::open(array('route' => array('truck.file.store', $truck->id),
                    'files' => 'true', 'class' => 'form-inline')) !!}
                {!! Form::file('image',array('class' => 'file' )) !!}
                {!! Form::submit('Загрузить файлы',array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}

            </div>
        </div>

        <div class="form-group">

            {!! Form::label('pictures', 'Загруженные файлы',
                array('class' => 'col-md-4 control-label')) !!}

            <div class="col-sm-6">
                @if (count($truck->files) > 0)

                    @foreach ($truck->files as $file)
                        <div class="pull-left">
                            @if (in_array($file->filetype,['image/jpg','image/jpeg','image/png','image/gif']) )
                                <input type="image" src="{{ route('file.show',$file->id) }}"
                                       height="60px" class="left"/>
                            @else
                                <input type="image" src="{{ url('/img/TRACKTOR.png') }}"
                                       height="60px" class="left" />
                            @endif

                            {!! Form::model($file,array('route' => ['file.destroy',$file->id]) ) !!}
                            {!! Form::submit('х',array('class' => 'btn btn-link')) !!}
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                @else
                    Отсутствуют
                @endif

                {!! Form::open(array('route' => array('truck.files.store', $truck->id),
                'files' => 'true')) !!}
                {!! Form::file('images[]',array('multiple' => true, 'class' => 'file' )) !!}
                {!! Form::submit('Загрузить файлы',array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}

            </div>
        </div>

    </div>

    {!! Form::model($truck,array('route' => array('truck.update', $truck->id),
        'method' => 'POST','class' => 'form form-horizontal')) !!}

    <!-- TRUCK UPDATE-->
    <div class="form-group">
        {!! Form::label('brand', 'Марка',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('brand', @$truck->brand, array('class' => 'form-control',
            'placeholder' => 'Пример: Мерцедес-Бенц')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('seria', 'Серия',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('seria', @$truck->seria, array('class' => 'form-control',
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
            {!! Form::select('truck_type_id', $typesArr, @$truck->track_type_id, array('class' => 'form-control')) !!}
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
            @$truck->country_id, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('gos_number', 'Гос.номер',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('gos_number', @$truck->gos_number, array('class' => 'form-control',
            'placeholder' => 'Пример: 16KZ540')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('width', 'Ширина',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-2">
            {!! Form::text('width', @$truck->width, array('class' => 'form-control')) !!}
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
            {!! Form::text('height', @$truck->width, array('class' => 'form-control')) !!}
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
            {!! Form::text('length', @$truck->width, array('class' => 'form-control')) !!}
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
            {!! Form::text('capacity', @$truck->capacity, array('class' => 'form-control')) !!}
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
            {!! Form::text('volume', @$truck->volume, array('class' => 'form-control')) !!}
        </div>
        <div class="col-md-2">
            {!! Form::label('volume', 'метров кубических',
                array('class' => 'control-label')) !!}
        </div>

    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            {!! Form::submit('Сохранить',array('class' => 'btn btn-primary')) !!}

            {!! link_to_route('truck.show','Назад',array('id' => $truck->id),array('class' => 'btn btn-link')) !!}
        </div>
    </div>

    {!! Form::close() !!}

@endsection