@extends('app')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Извините!</strong> Какие-то проблемы с вводом регистрационных данных.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label class="col-md-4 control-label">Фамилия</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="surname" value="{{ old('surname') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Имя</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-4 control-label">Отчество</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="father" value="{{ old('father') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">E-Mail адрес</label>
            <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Телефон</label>
            <div class="col-md-1">
                <input readonly="true" value="+7" class="form-control" />
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" size="10" name="phone_number" value="{{ old('phone_number') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Пароль</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Повторите пароль</label>
            <div class="col-md-6">
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Регистрация
                </button>
            </div>
        </div>
    </form>

@endsection
