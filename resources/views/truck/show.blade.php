@extends('app')

@section('title')
    Автомобиль грузоперевозчика {{ $truck->user->surname }} {{ $truck->user->name }}
@endsection

@section('content')

    <div class="form-horizontal">

        <div class="form-group">
            <h3 class="col-md-4 text-right">Автомобиль</h3>
            <div class="col-sm-6">
                @if (($truck->user && $truck->user->id == Auth::user()->id) ||
                        Auth::user()->is_admin > 0)
                    {!! Form::model($truck,array('route' => array('truck.destroy', $truck->id), 'method' => 'POST'))!!}
                    {!! link_to_route('truck.edit','Изменить',array('id' => $truck->id),
                        array('class' => 'btn btn-link')) !!}
                    {!! Form::submit('Удалить',array('class' => 'btn btn-link')) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Фото</strong>
            <div class="col-sm-6">

                @if ($truck->picture != null)
                    <input type="image" src="{{ route('file.show',$truck->picture->id) }}" height="80px" />
                @else
                    Нет изображения
                @endif

            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Загруженные файлы</strong>
            <div class="col-sm-6">
                @if (count($truck->files) > 0)

                    @foreach ($truck->files as $file)

                        @if (in_array($file->filetype,['image/jpg','image/jpeg','image/png','image/gif']) )
                            <input type="image" src="{{ route('file.show',$file->id) }}"
                                   height="60px" class="left"/>
                        @else
                            <input type="image" src="{{ url('/img/TRACKTOR.png') }}"
                                   height="60px" class="left" />
                        @endif

                    @endforeach
                @else
                    Отсутствуют
                @endif


            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Марка / Серия</strong>
            <div class="col-sm-6">
                {{ $truck->brand}} /
                {{ $truck->seria }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Страна регистрации</strong>
            <div class="col-sm-6">
                @if($truck->country)
                    {{ $truck->country->code . ' - ' . $truck->country->name }}
                @else
                    Не указана
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Гос. номер авто</strong>
            <div class="col-sm-6">
                {{ $truck->gos_number }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Тип кузова</strong>
            <div class="col-sm-6">
                {!! $truck->type->description !!}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Ширина</strong>
            <div class="col-sm-6">
                {{ $truck->width }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Длина</strong>
            <div class="col-sm-6">
                {{ $truck->length }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Высота</strong>
            <div class="col-sm-6">
                {{ $truck->height }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Грузоподъёмность</strong>
            <div class="col-sm-6">
                {{ $truck->capacity }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Объём</strong>
            <div class="col-sm-6">
                {{ $truck->volume }}
            </div>
        </div>

    </div>
@endsection