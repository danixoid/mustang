@extends('app')

@section('title')
    Редактирование фирмы
@endsection

@section('content')
    
    <div class="form-horizontal">

        <div class="form-group">

            {!! Form::label('pictures', 'Загруженные файлы',
            array('class' => 'col-md-4 control-label')) !!}

            <div class="col-sm-6">
                @if (count($legal->files) > 0)

                    @foreach ($legal->files as $file)
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

                {!! Form::open(array('route' => array('legal.files.store', $legal->id),
                'files' => 'true')) !!}
                {!! Form::file('images[]',array('multiple' => true, 'class' => 'file' )) !!}
                {!! Form::submit('Загрузить файлы',array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}

            </div>
        </div>

    </div>

    {!! Form::model($legal,array('route' => array('legal.update',$legal->id),
        'method' => 'POST','class' => 'form form-horizontal')) !!}

    <!-- legal UPDATE-->
    <div class="form-group">
        {!! Form::label('name', 'Название организации',
        array('class' => 'col-md-4 control-label')) !!}
        <div class="col-md-4">
            {!! Form::text('name', @$name, array('class' => 'form-control',
            'placeholder' => 'Пример: ТОО "Акниет"', 'readonly' => 'true')) !!}
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

            {!! link_to_route('legal.show','Назад',array('id' => $legal->id),array('class' => 'btn btn-link')) !!}
        </div>
    </div>
    
    {!! Form::close() !!}

@endsection