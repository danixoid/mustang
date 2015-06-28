@extends('app')

@section('content')

    @if(Auth::user()->activated == 0)
        Ваш профиль еще не активирован!<br />
        Пожалуйста, заполните все поля и отправьте на проверку.
    @else
        Вы в системе!
    @endif

@endsection
