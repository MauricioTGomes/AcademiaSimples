<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Controle acadêmia</title>
</head>


<body class="bg-dark">
<div class="container">
	<div class="card card-login mx-auto mt-5">
		<div class="card-header">Login</div>
		<div class="card-body">
			<form class="form-horizontal" role="form" method="POST" action="{{ route('logar') }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<label for="exampleInputEmail1">E-mail</label>
					<input class="form-control" name="email" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Senha</label>
					<input class="form-control" name="senha" type="password" placeholder="Senha">
				</div>
				<div class="form-group">
					<div class="form-check">
						<label class="form-check-label">
							<input class="form-check-input" type="checkbox">Relembrar senha</label>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">Entrar</button>
			</form>
		</div>
	</div>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script src="{{ elixir('js/all.js') }}"></script>
<link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>

<link href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/sb-admin.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>

</body>

</html>
