@extends('app')


@section('content')

    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>E-Mail</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Операция</th>
        </tr>

        <?php $i = 1; ?>

        @foreach($users as $user)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->surname }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->father }}</td>
                <td>
                    {!! link_to_route('user.show','Профиль',array('id' => $user->id),
                    array('class' => 'btn btn-link')) !!}
                    @if (Auth::user()->is_admin == 1)
                        {!! link_to_route('user.destroy','Удалить',array('id' => $user->id),
                        array('class' => 'btn btn-link')) !!}
                    @endif
                </td>
            </tr>
        @endforeach

    </table>

@endsection