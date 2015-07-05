@extends('app')

@section('content')

    <div class="form-horizontal">
        <div class="form-group">

            {!! Form::label('email', 'Активация аккаунта',
                array('class' => 'col-md-4 control-label')) !!}

            <div class="col-md-6">

                @if ($user->activated == 0)
                    <p class="bg-danger">Профиль не активирован</p>
                @else
                    <p class="bg-success">Профиль активирован</p>
                @endif

                @if (Auth::user()->is_admin > 0)

                    @if ($user->activated == 0)
                        {!! Form::open(array('route' => array('user.activate', $user->id))) !!}
                        {!! Form::submit('Активировать',array('class' => 'btn btn-success')) !!}
                        {!! Form::close() !!}
                    @else
                        {!! Form::open(array('route' => array('user.deactivate', $user->id))) !!}
                        {!! Form::submit('Деактивировать',array('class' => 'btn btn-danger')) !!}
                        {!! Form::close() !!}
                    @endif

                @endif
            </div>
        </div>

        <div class="form-group">

            {!! Form::label('picture', 'Фото',
                array('class' => 'col-md-4 control-label')) !!}

            <div class="col-sm-6">

                @if ($user->picture != null)
                    <input type="image" src="{{ route('file.show',$user->picture->id) }}" height="80px" />
                @else
                    Нет изображения
                @endif

                {!! Form::open(array('route' => array('user.file.store', $user->id),
                    'files' => 'true', 'class' => 'form-inline')) !!}
                {!! Form::file('image',array('class' => 'file' )) !!}
                {!! Form::submit('Загрузить файлы',array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}

            </div>
        </div>

        <div class="form-group">

            {!! Form::label('pictures', 'Загруженные файлы',
            array('class' => 'col-md-4 control-label')) !!}

            <div class="col-sm-6">
                @if (count($user->files) > 0)

                    @foreach ($user->files as $file)

                        <div class="pull-left">
                            @if (in_array($file->filetype,['image/jpg','image/jpeg','image/png','image/gif']) )
                                <input type="image" src="{{ route('file.show',$file->id) }}"
                                       height="60px" class="left"/>
                            @else
                                <input type="image" src="{{ url('/img/TRACKTOR.png') }}"
                                       height="60px" class="left" />
                            @endif


                            {!! Form::model($file,array('route' => ['file.destroy',$file->id]) ) !!}
                            {!! Form::submit('х',array('class' => 'btn btn-link')) !!}
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                @else
                    Отсутствуют
                @endif

                {!! Form::open(array('route' => array('user.files.store', $user->id),
                'files' => 'true')) !!}
                {!! Form::file('images[]',array('multiple' => true, 'class' => 'file' )) !!}
                {!! Form::submit('Загрузить файлы',array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}

            </div>
        </div>

        <div class="form-group">
            {!! Form::label('father', 'Контактные телефоны',
                array('class' => 'col-md-4 control-label')) !!}
            <div class="col-md-6">
                @if (count($user->phones) > 0)
                    @foreach ($user->phones as $phone)
                        {!! Form::model($phone,array('route' => array('phone.destroy',$phone->id),
                        'method' => 'POST'))!!}
                        {{ $phone->phone_number }}
                        @if ($phone->confirmed  == 0)[не подтверждён]@endif
                        {!! Form::submit('Удалить',
                        array('class' => 'btn btn-link')) !!}
                        {!! Form::close() !!}
                    @endforeach
                @else
                    Отсутствуют
                @endif
            </div>
        </div>
    </div>

    {!! Form::open(array('route' => 'phone.store',
        'method' => 'POST', 'class' => 'form-horizontal'))!!}
    <div class="form-group">
        {!! Form::label('father', 'Добавить телефон',
            array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('phone_number','',array('class' => 'form-control',
                'placeholder' => 'Пример, 7774260576')) !!}
            {!! Form::hidden('confirmed','0') !!}
            {!! Form::hidden('user_id',$user->id) !!}
        </div>
        <div class="col-md-2">
            {!! Form::submit('Добавить телефон',
            array('class' => 'btn btn-primary')) !!}
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::model($user, array('route' => array('user.update', $user->id),
        'method' => 'POST','class' => 'form-horizontal')) !!}

    <div class="form-group">
        {!! Form::label('email', 'E-Mail',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-6">
            {!! Form::text('email', @$email, array('class' => 'form-control',
            'readonly' => 'true', 'placeholder' => 'john@example.com')) !!}
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
        {!! Form::label('legal', 'Фирма',
            array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            <input type="text" id="search_legal" value="{{ @$user->legal->name }}" class="form-control" />
            {!! Form::hidden('legal_id', @$user->legal_id, array('id' => 'legal_id')) !!}
        </div>
        <div class="col-md-2">
            {!! link_to_route('legal.create','[Добавить фирму]',['id' => $user->id],
                ['class' => 'btn btn-link']); !!}
            <button class="btn btn-link" onclick="clear_legal();return false;">[Очистить]</button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-6">

            {!! Form::submit('Сохранить',array("class" => "btn btn-primary")) !!}
            {!! link_to_route('user.profile','Назад',[],['class' => 'btn btn-link']); !!}
        </div>
    </div>


    {!! Form::close() !!}
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.2.21/jquery.autocomplete.min.js"></script>
    <script>

        $(function(){


            $('#search_legal').autocomplete({
                ajaxSettings : {
                    'method' :'POST',
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                    'dataType' : 'json',
                    'statusCode' : {
                        404: function() {
                            alert( "page not found" );
                        }
                    }
                },
                'serviceUrl' : '{{ route('json.legal') }}',
                'paramName' : 'search',
                'onSelect' : function (suggestion) {
                    $('#legal_id').val(suggestion.data);
                },
                'transformResult' : function(response) {
                    return {
                        suggestions: $.map(response, function(dataItem) {
                            return { value: dataItem.name, data: dataItem.id };
                        })
                    };
                },

                minLength : 3
            });

            $('#search_legal').on('keydown',function(event) {
                return event.keyCode != 13;
            });
        })

        function clear_legal() {
            $('#search_legal').val('');
            $('#legal_id').val('');
        }
    </script>

@endsection

@section('meta')
    <meta name="_token" content="{{ csrf_token() }}"/>

    <style>
        .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
        .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
        .autocomplete-selected { background: #F0F0F0; }
        .autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
        .autocomplete-group { padding: 2px 5px; }
        .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
    </style>
@endsection