@extends('app')

@section('title')
    Новая фирма
@endsection

@section('content')


    {!! Form::open(array('route' => array('legal.store',$id),
    'method' => 'POST','class' => 'form form-horizontal')) !!}

    <!-- legal UPDATE-->
    <div class="form-group">
        {!! Form::label('name', 'Название организации',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('name', @$name, array('class' => 'form-control',
            'placeholder' => 'Пример: ТОО "Акниет"')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('email', 'E-Mail',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('email', @$seria, array('class' => 'form-control',
            'placeholder' => 'Пример: info@akhniet.kz')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        {!! Form::label('director', 'Представитель / Директор (Ф.И.О.)',
            array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('director', @$seria, array('class' => 'form-control',
            'placeholder' => 'Пример: Smith John Black')) !!}
        </div>
        <div class="col-md-2"></div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            {!! Form::submit('Сохранить',array('class' => 'btn btn-primary')) !!}

            {!! link_to_route('user.show','Назад',array('id' => $id),array('class' => 'btn btn-link')) !!}
        </div>
    </div>

    {!! Form::close() !!}

@endsection