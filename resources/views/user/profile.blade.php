@extends('app')

@section('content')


    <div class="form-horizontal">
        <div class="form-group">
            <h3 class="col-md-4 text-right">
                {{ $user->surname }}
                {{ $user->name }}
                {{ $user->father }}
            </h3>

            <div class="col-sm-6">
                @if ($user->picture != null)
                    <input type="image" height="300" src="{{ url($user->picture->uri) }}"/>
                @else
                    <input type="image" src="{{ url('/img/TRACKTOR.png') }}"/>
                @endif

                @if ($user->activated == 0)
                    <p class="bg-danger">Профиль не активирован</p>
                    {!! Form::open(array('route' => array('user.activate', $user->id))) !!}
                    {!! Form::submit('Активировать',array('class' => 'btn btn-success')) !!}
                    {!! Form::close() !!}
                @else
                    <p class="bg-success">Профиль активирован</p>
                    {!! Form::open(array('route' => array('user.deactivate', $user->id))) !!}
                    {!! Form::submit('Деактивировать',array('class' => 'btn btn-danger')) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">E-Mail</strong>
            <div class="col-sm-6">
                {{ $user->email }}
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Страна</strong>
            <div class="col-sm-6">
                @if ($user->country != null )
                    {{ $user->country->name }}
                @else
                    Не определено
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Резидент</strong>
            <div class="col-sm-6">
                @if ($user->resident == 0)
                    Нет
                @else
                    Да
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Привелегии</strong>
            <div class="col-sm-6">
                @if ($user->is_admin > 0)
                    Администратор
                @else
                    Пользователь
                @endif
            </div>
        </div>

        <div class="form-group">
            <strong class="col-md-4 text-right">Номера мобильных телефонов</strong>
            <div class="col-sm-6">
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
                {!! Form::open(array('route' => 'phone.store',
                    'method' => 'POST', 'class' => 'form-inline'))!!}
                    <div class="form-group">
                        {!! Form::text('phone_number','',array('class' => 'form-control',
                            'placeholder' => 'Пример, 7774260576')) !!}
                    </div>
                    {!! Form::hidden('confirmed','0') !!}
                    {!! Form::hidden('user_id',$user->id) !!}
                    {!! Form::submit('Добавить телефон',
                        array('class' => 'btn btn-primary')) !!}
                {!! Form::close() !!}
            </div>
        </div>

        @if ($user->id == Auth::user()->id || Auth::user()->is_admin == 1)
            <div class="form-group">
                <div class="col-md-offset-4 col-md-6">
                    {!! link_to_route('user.edit','Изменить',['id' => $user->id],
                            ['class' => 'btn btn-primary']); !!}
                </div>
            </div>
        @endif

        <!-- -->

        @if ($user->truck_id == null)

            <div class="form-group">
                <h3 class="col-md-4 text-right">Нет автомобиля</h3>
            </div>

                @if ($user->activated == 0)


                {!! Form::open(array('route' => array('user.truck.store', $user->id),
                    'method' => 'POST','class' => 'form form-horizontal')) !!}

                <!-- TRUCK UPDATE-->
                <div class="form-group">
                    {!! Form::label('brand', 'Марка',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('brand', @$user->truck->brand, array('class' => 'form-control',
                        'placeholder' => 'Пример: Мерцедес-Бенц')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('seria', 'Серия',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('seria', @$user->truck->seria, array('class' => 'form-control',
                        'placeholder' => 'Пример: C220')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('truck_type_id', 'Тип кузова',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        <?php
                        $types = App\Models\TruckType::all();
                        $typesArr = [];
                        foreach($types as $type) {

                            preg_match( '/[а-яА-Я\w\d\s\-\"]+/u', $type->description, $match );

                            if(count($match) > 0)
                                $typesArr[$type->id] = $match[0];
                            else
                                $typesArr[$type->id] = $type->description;
                        }
                        ?>
                        {!! Form::select('truck_type_id', $typesArr,
                        @$user->truck->track_type_id, array('class' => 'form-control')) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('country_id', 'Страна регистрации',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        <?php
                        $countries = App\Models\Country::all();
                        $countryArr = [];

                        foreach($countries as $country) {
                            $countryArr[$country->id] = $country->code
                                    . ' - ' . $country->name;
                        }
                        ?>
                        {!! Form::select('country_id', $countryArr,
                        @$user->truck->country_id, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('gos_number', 'Гос.номер',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('gos_number', @$user->truck->gos_number, array('class' => 'form-control',
                        'placeholder' => 'Пример: 16KZ540')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('width', 'Ширина',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('width', @$user->truck->width, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('height', 'Высота',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('height', @$user->truck->width, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('length', 'Длина',
                    array('class' => 'col-md-4 control-label')) !!}
                    <div class="col-md-6">
                        {!! Form::text('length', @$user->truck->width, array('class' => 'form-control')) !!}
                    </div>
                </div>

                @if ($user->id == Auth::user()->id || Auth::user()->is_admin > 0)
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-6">
                            {!! Form::submit('Сохранить',array('class' => 'btn btn-primary')) !!}
                        </div>
                    </div>
                @endif

                {!! Form::close() !!}

            @endif

        @else

            <div class="form-group">
                <h3 class="col-md-4 text-right">Автомобиль</h3>
                <div class="col-md-6">
                    @if ($user->truck->picture != null)
                        <input type="image" height="300" src="{{ url($user->truck->picture->uri) }}"/>
                    @else
                        <input type="image" src="{{ url('/img/EUROFURA.png') }}"/>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <strong class="col-md-4 text-right">Марка</strong>
                <div class="col-sm-6">
                    {{ $user->truck->brand}}
                    {{ $user->truck->seria }}
                </div>
            </div>

            <div class="form-group">
                <strong class="col-md-4 text-right">Гос. номер авто</strong>
                <div class="col-sm-6">
                    {{ $user->truck->gos_number }} <br />
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-4 col-sm-6">

                    {!! Form::model($user->truck,array('route' => array('user.truck.destroy',
                    $user->id), 'method' => 'POST'))!!}
                    {!! Form::submit('Удалить автомобиль',array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
            </div>

        @endif
    </div>
@endsection