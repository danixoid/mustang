@extends('app')

@section('title')
    Профили пользователей
@endsection

@section('content')

    {!! link_to_route('user.trash','Удалённые',array('class' => 'btn btn-link')) !!}

    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>E-Mail</th>
            <th>Ф.И.О.</th>
            <th>Телефоны</th>
            <th></th>
        </tr>

        <?php
            $page = $users->currentPage();
            $i = 1 + ((int)$page - 1) * $users->perPage();
        ?>

        @foreach($users as $user)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->surname }} {{ $user->name }} {{ $user->father }}</td>
                <td>
                    @if (count($user->phones) > 0)
                        @foreach ($user->phones as $phone)
                            {{ $phone->phone_number }}
                        @endforeach
                    @else
                        Отсутствуют
                    @endif
                </td>
                <td>
                    @if (Auth::user()->is_admin == 1)
                        {!! Form::model($user,array('route' => array('user.destroy',$user->id),
                            'class' => 'form-inline', 'method' => 'POST'))!!}
                        {!! link_to_route('user.show','Профиль',array('id' => $user->id),
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::submit('Удалить',
                            array('class' => 'btn btn-link')) !!}
                        {!! Form::close() !!}
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

    {!! $users->render() !!}

@endsection