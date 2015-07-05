@extends('app')

@section('content')

    <div class="form-horizontal">
        <div class="form-group">
            <h3 class="col-md-4 text-right">
                {{ $legal->name }}
            </h3>
            <div class="col-md-6">
                {!! Form::model($legal,array('route' => array('legal.destroy', $legal->id), 'method' => 'POST'))!!}

                {!! link_to_route('legal.edit','Изменить',array('id' => $legal->id),array('class' => 'btn btn-link')) !!}

                {!! Form::submit('Удалить',array('class' => 'btn btn-link')) !!}
                {!! Form::close() !!}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Директор, Ф.И.О.</strong>
            <div class="col-sm-6">
                {{ $legal->director }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">E-Mail</strong>
            <div class="col-sm-6">
                {{ $legal->email }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Загруженные файлы</strong>
            <div class="col-sm-6">
                @if (count($legal->files) > 0)

                    @foreach ($legal->files as $file)

                        @if (in_array($file->filetype,['image/jpg','image/jpeg','image/png','image/gif']) )
                            <input type="image" src="{{ route('file.show',$file->id) }}"
                                   height="60px" class="left"/>
                        @else
                            <input type="image" src="{{ url('/img/TRACKTOR.png') }}"
                                   height="60px" class="left" />
                        @endif

                    @endforeach
                @else
                    Отсутствуют
                @endif


            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-sm-6">


            </div>
        </div>

    </div>
@endsection