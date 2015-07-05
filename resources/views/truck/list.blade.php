@extends('app')


@section('content')

    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>Водитель</th>
            <th>Марка и серия</th>
            <th>Гос.номер</th>
            <th>Тип кузова</th>
            <th>Ширина</th>
            <th>Длина</th>
            <th>Высота</th>
            <th>Грузоподъёмность</th>
            <th>Объём</th>
            <th></th>
        </tr>

        <?php
            $page = $trucks->currentPage();
            $i = 1 + ((int)$page - 1) * $trucks->perPage();
        ?>

        @foreach($trucks as $truck)
            <tr>
                <td>{{ $i++ }}</td>
                <td>

                    {{ $truck->user->surname }} {{ $truck->user->name }} {{ $truck->user->father }}
                    {!! link_to_route('user.show','[Профиль]',$truck->user->id) !!}
                </td>
                <td>{{ $truck->brand }} {{ $truck->seria }}</td>
                <td>{{ $truck->gos_number }}</td>
                <td>
                    <?php
                        $type_name = [];
                        preg_match( '/[а-яА-Я\w\d\s\-\"]+/u', $truck->type->description, $type_name );
                    ?>
                    {{ $type_name[0] }}

                </td>
                <td>{{ $truck->width }}</td>
                <td>{{ $truck->length }}</td>
                <td>{{ $truck->height }}</td>
                <td>{{ $truck->capacity }}</td>
                <td>{{ $truck->volume }}</td>
                <td>
                    @if (Auth::user()->is_admin == 1)
                        {!! Form::model($truck,array('route' => array('truck.destroy',$truck->id),
                            'class' => 'form-inline', 'method' => 'POST'))!!}
                        {!! link_to_route('truck.show','Просмотр',array('id' => $truck->id),
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::submit('Удалить',
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

    {!! $trucks->render() !!}

@endsection