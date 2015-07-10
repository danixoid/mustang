@extends('app')


@section('content')

    <table class="table table-condensed">
        <tr>
            <th>№ п.п</th>
            <th>E-Mail</th>
            <th>Ф.И.О.</th>
            <th>Телефоны</th>
            <th>Восстановить</th>
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
                    {!! Form::open(array('route' => array('user.restore', $user->id))) !!}
                    {!! Form::submit('Восстановить',array('class' => 'btn btn-success')) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach

    </table>

    {!! $users->render() !!}

@endsection