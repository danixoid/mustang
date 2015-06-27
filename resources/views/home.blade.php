@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Главная</div>

				<div class="panel-body">
					@if(Auth::user()->activated == 0)
                        Ваш профиль еще не активирован!<br />
                        Пожалуйста, заполните все поля и отправьте на проверку.
                    @else
                        Вы в системе!
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
