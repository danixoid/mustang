@extends('app')

@section('title')
    Добро пожаловать!
@endsection

@section('content')

    <ul>

    @if(count(Auth::user()->phones) < 1)
        <li>
            {!! link_to_route('user.edit','Добавьте телефоны',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->picture)
        <li>
            {!! link_to_route('user.edit','Добавьте фотографию',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->country)
        <li>
            {!! link_to_route('user.edit','Укажите гражданство',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->truck)
        <li>
            {!! link_to_route('truck.create','Добавьте грузовой автомобиль,',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            чтобы работать в системе как Грузоперевозчик
        </li>
    @endif

    @if(!Auth::user()->legal)
        <li>
            {!! link_to_route('legal.create','Укажите фирму (физ.лицо, юр.лицо),',
            ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            чтобы работать в системе как Грузоотправитель
        </li>
    @elseif(count(Auth::user()->legal->files) == 0)
        <li>
            {!! link_to_route('legal.edit','Добавьте файлы для подтверждения вашей фирмы,',
            ['id' => Auth::user()->legal->id],array('class' => 'btn btn-link')) !!}
            чтобы работать в системе как Грузоотправитель
        </li>
    @endif

    </ul>
@endsection
