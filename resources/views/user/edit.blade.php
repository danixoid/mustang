@extends('app')

@section('content')

    {!! Form::model($user, array('route' =>
        array('user.store', $user->id),
        'method' => 'POST','class' => 'form form-horizontal')) !!}


    <div class="form-group">
        {!! Form::label('email', 'E-Mail',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-6">
            {!! Form::text('email', @$email, array('class' => 'form-control',
            'placeholder' => 'john@example.com')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('surname', 'Фамилия',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-6">
            {!! Form::text('surname', @$surname, array('class' => 'form-control',
            'placeholder' => 'Smith')) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('name', 'Имя',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-6">
            {!! Form::text('name', @$name, array('class' => 'form-control',
            'placeholder' => 'John')) !!}
        </div>
    </div>

    <div class="form-group">
            {!! Form::label('father', 'Отчество',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-6">
            {!! Form::text('father', @$father, array('class' => 'form-control',
            'placeholder' => 'Black')) !!}
        </div>
    </div>





    <div class="form-group">
        <div class="col-md-offset-4 col-md-6">
            {!! Form::submit('Сохранить',array("class" => "btn btn-primary")) !!}
            {!! link_to(URL::previous(),'Назад',[],['class' => 'pull-right btn btn-link']); !!}
        </div>
    </div>


    {!! Form::close() !!}
@endsection
