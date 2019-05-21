<!DOCTYPE html>
<html lang="pt">
@extends('index')
@section('conteudo')
<body class="bg-dark">
<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Registrar usuário</div>
        <div class="card-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/gravar') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputName">Nome</label>
                            <input class="form-control" name="nome" type="text" aria-describedby="nameHelp"
                                   placeholder="Nome">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputLastName">Sobrenome</label>
                            <input class="form-control" name="sobrenome" type="text"
                                   aria-describedby="nameHelp" placeholder="Sobrenome">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">E-mail</label>
                    <input class="form-control" name="email" type="email" aria-describedby="emailHelp"
                           placeholder="E-mail">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputPassword1">Senha</label>
                            <input class="form-control" name="senha" type="password"
                                   placeholder="Senha">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleConfirmPassword">Confirme a senha</label>
                            <input class="form-control" name="confirmSenha" type="password"
                                   placeholder="Confirme a senha">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    Registrar
                </button>
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
@endsection