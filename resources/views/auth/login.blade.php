@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Вход в систему</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Ой!</strong> Какие-то проблемы с вводом.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                    {!! Form::open(array('url' => url('auth/login'), 'class' => 'form form-horizontal')) !!}

                        <div class="form-group">

                            {!! Form::label('email', 'E-Mail адрес', array('class' => 'col-md-4 control-label')) !!}

                            <div class="col-md-6">
                                {!! Form::text('email', @$email, array("class" => "form-control",
                                'placeholder' => 'email@example.com')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('password', 'Пароль', array('class' => 'col-md-4 control-label')) !!}

                            <div class="col-md-6">
                                {!! Form::password('password', array("class" => "form-control",
                                'placeholder' => 'My23Cool12Passwd1!')) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('remember', 'value', false) !!} Запомнить
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-6">
                                {!! Form::submit('Войти',array("class" => "btn btn-primary")) !!}

                                {!! link_to('/password/email', 'Забыли пароль',
                                    array('class' => 'btn btn-link', null)) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}


                        <!--
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
							<label class="col-md-4 control-label">E-Mail адрес</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>
						<div class="form-group">
                            <label class="col-md-4 control-label">Номер телефона</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>


                        <div class="form-group">
							<label class="col-md-4 control-label">Пароль</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Запомнить
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Войти</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Забыли пароль?</a>
							</div>
						</div>
					</form>
                        -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
