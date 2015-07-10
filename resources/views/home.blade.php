@extends('app')

@section('content')

    <h2>Добро пожаловать!</h2>

    Чтобы работать в системе как Грузоотправитель необходимо проделать следующее:
    <ul>

    @if(count(Auth::user()->phones) < 1)
        <li>
            {!! link_to_route('user.edit','Добавить телефоны',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->picture)
        <li>
            {!! link_to_route('user.edit','Добавить фотографию',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->country)
        <li>
            {!! link_to_route('user.edit','Указать гражданство',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    @if(!Auth::user()->truck)
        <li>
            {!! link_to_route('truck.create','Добавить грузовой автомобиль',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
        </li>
    @endif

    </ul>


    Чтобы работать в системе как Грузоперевозчик необходимо проделать следующее:
    <ul>

        @if(count(Auth::user()->phones) < 1)
            <li>
                {!! link_to_route('user.edit','Добавить телефоны',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            </li>
        @endif

        @if(!Auth::user()->picture)
            <li>
                {!! link_to_route('user.edit','Добавить фотографию',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            </li>
        @endif

        @if(!Auth::user()->country)
            <li>
                {!! link_to_route('user.edit','Указать гражданство',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            </li>
        @endif

        @if(!Auth::user()->legal)
            <li>
                {!! link_to_route('legal.create','Указать фирму (физ.лицо, юр.лицо)',
                ['id' => Auth::user()->id],array('class' => 'btn btn-link')) !!}
            </li>
        @endif

    </ul>
@endsection
