@extends('app')

@section('javascript')
    <meta name="_token" content="{{ csrf_token() }}"/>

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script>
        $(function() {

            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

            $.ajax({
                'method' : 'POST',
                'url' : '{{ url('/auth/login') }}',
                'dataType' : 'json',
                'data' : {
                    'email': 'danixoid1@gmail.com',
                    'password': 'Roamer'
                },
                'success' : function (data) {
                    alert(JSON.stringify(data));
                },
                'error' : function (error) {
                    alert(JSON.stringify(error));
                }
            });

        });
    </script>


@section('content')
    Бла бла бла
@endsection
