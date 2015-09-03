@extends('app')

@section('content')

    {!! Form::open(array('url' => url('auth/login'), 'class' => 'form form-horizontal')) !!}



        <div class="form-group">

            {!! Form::label('phone_number', 'или телефон', array('class' => 'col-md-4 control-label')) !!}

            <div class="col-md-1">
                {!! Form::text('phone_prefix', "+7", array("class" => "form-control",
                    'placeholder' => '+7','readonly' => true)) !!}
            </div>
            <div class="col-md-5">
                {!! Form::text('phone_number', @$phone_number, array("class" => "form-control",
                'placeholder' => '777 426 05 76')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Пароль', array('class' => 'col-md-4 control-label')) !!}

            <div class="col-md-6">
                {!! Form::password('password', array("class" => "form-control",
                'placeholder' => 'My23Cool12Passwd1!')) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('remember', 'value', false) !!} Запомнить
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-6">
                {!! Form::submit('Войти',array("class" => "btn btn-primary")) !!}

                {!! link_to('/password/email', 'Забыли пароль',
                    array('class' => 'btn btn-link', null)) !!}
            </div>
        </div>
    {!! Form::close() !!}


        <!--
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label class="col-md-4 control-label">E-Mail адрес</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Номер телефона</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label">Пароль</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Запомнить
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Войти</button>

                <a class="btn btn-link" href="{{ url('/password/email') }}">Забыли пароль?</a>
            </div>
        </div>
    </form>
        -->
@endsection
