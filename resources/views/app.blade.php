<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mustang</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


    @yield('meta')


    
</head>
<body>
	<nav class="navbar navbar-mustang">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Навигация</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="pull-left" href="#">
                    <input type="image" height="50px" src="{{url('/img/mustang.png')}}" />
                </a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">

                    <li><a href="{{ url('/') }}">Главная</a></li>
                    @if (!Auth::guest())
                        <li><a href="{{ url('/distance') }}">Рассчет расстояний</a></li>
                        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Найти грузоперевозчиков</a>
                            <ul class="dropdown-menu" role="menu">
                                <li>{!! link_to_route('work.map','На карте') !!}</li>
                                <li>{!! link_to_route('truck.list','По критериям') !!}</li>
                            </ul>
                        </li>
                    @endif

                    <li><a href="{{ url('/rules') }}">Соглашение</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Войти</a></li>
						<li><a href="{{ url('/auth/register') }}">Регистрация</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
                                @if (Auth::user()->is_admin > 0)
                                <li><a href="{{ route('user.list') }}">Список пользователей</a></li>
                                @endif
                                <li><a href="{{ route('user.profile') }}">Профиль</a></li>
								<li><a href="{{ url('/auth/logout') }}">Выйти</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>


    <div class="container">

                @if(Session::has('success'))
                    <div class="alert-box alert-success">
                        <h3>{{ Session::get('success') }}</h3>
                    </div>
                @endif

                @if(Session::has('warning'))
                    <div class="alert-box alert-warning">
                        <h3>{{ Session::get('warning') }}</h3>
                    </div>
                @endif

                @if(Session::has('message'))
                    <div class="alert-box alert-info">
                        <h3>{{ Session::get('message') }}</h3>
                    </div>
                @endif

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

                @yield('content')

    </div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    @yield('javascript')
</body>
</html>
