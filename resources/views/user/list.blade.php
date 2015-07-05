@extends('app')


@section('content')

    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>E-Mail</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
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
                <td>{{ $user->surname }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->father }}</td>
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