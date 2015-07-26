<html>
	<head>
		<title>Мустанг - система управления и слежения грузоперевозок</title>

        <link href='http://fonts.googleapis.com/css?family=Play&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

        <style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #FFFFFF;/*#B0BEC5;*/
				display: table;
				font-weight: 100;
                font-family: 'Play', sans-serif;
                background-color: #0085FF;
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
                background: transparent url(/img/mustang.png) top center no-repeat;
                background-size: auto 30%;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 96px;
				margin-bottom: 40px;
			}

			.quote {
				font-size: 24px;
			}
            a, a:visited {
                color: inherit;
            }
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
                <div class="quote">система управления и слежения грузоперевозок</div>
				<div class="title">MUSTANG</div>
				<!--<div class="quote">{{ Inspiring::quote() }}</div>-->
                <div class="quote">
                    <a href="{{ url('auth/login') }}">Войдите</a> в систему или
                    <a href="{{ url('auth/register') }}">зарегистрируйтесь</a>
                </div>
			</div>
		</div>
	</body>
</html>
