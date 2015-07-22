@extends('app')

@section('title')
    Оставьте отзыв
@endsection

@section('meta')
    <link href="{{asset("/css/star-rating.min.css")}}"  rel="stylesheet">
@endsection

@section('content')



    {!! Form::open(array('route' => array('rating.store'),'method' => 'post',
        'class' => 'form-horizontal')) !!}
    {!! Form::hidden('user_id',Auth::user()->id) !!}
    {!! Form::hidden('tracked_id',$tracked->id) !!}


    <div class="form-group">
        {!! Form::label('votes','ФИО грузоперевозчика',array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-6">
            <input class="form-control" readonly="true"
            value="{{ $tracked->surname }} {{ $tracked->name }} {{ $tracked->father }}"
                    />
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('votes','Автомобиль',array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-6">
            <input class="form-control" readonly="true"
               value="{{ $tracked->truck->brand }} / {{ $tracked->truck->seria }} {{ $tracked->truck->gos_number }}"
            />
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('votes','Оценка',array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-6">
            {!! Form::number('votes',old('votes'),array('id' => 'votes' )) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('details','Отзыв',array('class' => 'col-md-3 control-label')) !!}
        <div class="col-md-6">
            {!! Form::textarea('details',old('details'),array('class' => 'form-control')) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-3 col-md-6">
            {!! Form::submit('Отправить',array('id' => 'rating_submit','class' => 'btn btn-primary')) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection


@section('javascript')
    <script src="{{asset("/js/star-rating.min.js")}}"  rel="stylesheet"></script>
    <script>
        $(function(){
            $("#votes").rating({
                'showClear' : false,
                'min' : 0,
                'max' : 5,
                'step' : 1,
                'size' : 'xs',
                'defaultCaption' : 'Оценка {rating}',
                'clearCaption' : 'Выберите оценку',
                'starCaptions' : ['Никак','Ужасно','Плохо','Терпимо','Хорошо','Отлично']
            });

        });
    </script>
@endsection