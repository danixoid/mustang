@extends('app')

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('javascript')
    <!--JavaScript-->
    <script>

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        $(function () {
            $('#confirm_token').attr('disabled',true);
        });

        function sms_token_send(id) {

            $.ajax({
                'url' : "/sms/token/" + id + "/send",
                'method' : "POST",
                'dataType' : 'json',
                'beforeSend' : function () {
                    $('#send_token').hide();
                },
                'success' : function(data) {
                    alert(JSON.stringify(data));
                    $('#confirm_token').removeAttr('disabled');
                },
                'error': function(data) {
                    $('#error').html("Не удалось отправить код на СМС."
                            + JSON.stringify(data) );
                }
            });
        }

    </script>
@endsection


@section('content')

    <?php
        $phone = \App\Models\Phone::find($phone_id);
    ?>

    {!! Form::open(array('route' => array('sms.token.confirm',$phone_id),
        'method' => 'post','class' => 'form-horizontal')) !!}
    {!! Form::hidden('user_id',Auth::user()->id) !!}

    <div class="form-group">
        {!! Form::label('token','Введите код с СМС',array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-3">
            {!! Form::text('token','',array('id' => 'token',
                'autocomplete' => 'off','class' => 'form-control disabled')) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-3 col-md-6">
            {!! Form::submit('Активировать',array('id'=>'confirm_token','class' => 'btn btn-primary')) !!}
            <a id='send_token' class="btn btn-link" href="javascript:sms_token_send({!! $phone->id !!})">Получить код</a>
        </div>
    </div>
    {!! Form::close() !!}

    <div id="error"></div>

@endsection

@section('title')
    Подтверждение номера телефона +7{!! $phone->phone_number !!}
@endsection
