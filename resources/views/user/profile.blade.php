@extends('app')

@section('content')


    <div class="form-horizontal">
        <div class="form-group">
            <h3 class="col-md-4 text-right">
                {{ $user->surname }}
                {{ $user->name }}
                {{ $user->father }}
            </h3>
            <div class="col-md-6">
                {!! link_to_route('user.edit','Изменить',['id' => $user->id],
                    ['class' => 'btn btn-link']); !!}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Фото</label>
            <div class="col-sm-6">

                @if ($user->picture != null)
                    <input type="image" src="{{ route('file.show',$user->picture->id) }}" height="80px" />
                @else
                    Нет изображения
                @endif

            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Загруженные файлы</label>
            <div class="col-sm-6">
                @if (count($user->files) > 0)

                    @foreach ($user->files as $file)

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
            <label class="col-md-4 control-label">E-Mail</label>
            <div class="col-sm-6">
                {{ $user->email }}
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Страна</label>
            <div class="col-sm-6">
                @if ($user->country != null )
                    {{ $user->country->name }}
                @else
                    Не определено
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Резидент</label>
            <div class="col-sm-6">
                @if ($user->resident == 0)
                    Нет
                @else
                    Да
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Привелегии</label>
            <div class="col-sm-6">
                @if ($user->is_admin > 0)
                    <strong>Администратор</strong>
                @else
                    Пользователь
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Автомобиль</label>
            <div class="col-sm-6">
                @if ($user->truck)
                    {{ $user->truck->brand }} / {{ $user->truck->seria }} / {{ $user->truck->gos_number }}
                    {!! link_to_route('truck.show', '[Просмотр]', ['id' => $user->truck_id], ['class' => 'btn btn-link']); !!}
                @else
                    Нет автомобиля
                    {!! link_to_route('truck.create','[Добавить автомобиль]',['id' => $user->id],
                        ['class' => 'btn btn-link']); !!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Фирма</label>
            <div class="col-sm-6">
                @if ($user->legal)
                    {{ $user->legal->name }}
                    {!! link_to_route('legal.show','[Просмотр]',['id' => $user->legal_id],
                        ['class' => 'btn btn-link']); !!}
                @else
                    Работаю нелегально
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label">Номера мобильных телефонов</label>
            <div class="col-sm-6">
                @if (count($user->phones) > 0)
                    @foreach ($user->phones as $phone)
                        <p>
                            {{ $phone->phone_number }}
                            @if ($phone->confirmed  == 0)[не подтверждён]@endif
                        </p>
                    @endforeach
                @else
                    Отсутствуют
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-6">

            </div>
        </div>


    </div>
@endsection