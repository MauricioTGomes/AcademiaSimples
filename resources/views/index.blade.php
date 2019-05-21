<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Controle de acadêmia</title>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/">Controle de acadêmia</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('pessoas.listar') }}">
                    <i class="fa fa-fw fa-wrench"></i>
                    <span class="nav-link-text">Pessoas</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('contas.pagar.listar') }}">
                    <i class="fa fa-money"></i>
                    <span class="nav-link-text">Contas pagar</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('contas.receber.listar') }}">
                    <i class="fa fa-money"></i>
                    <span class="nav-link-text">Contas receber</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('pacote.listar') }}">
                    <i class="fa fa-fw fa-file"></i>
                    <span class="nav-link-text">Pacotes</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('pacotesCliente.listar') }}">
                    <i class="fa fa-fw fa-wrench"></i>
                    <span class="nav-link-text">Cadastrar plano ao cliente</span>
                </a>
            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Planos cliente">
                <a class="nav-link" href="{{ route('faturamento.listar') }}">
                    <i class="fa fa-fw fa-link"></i>
                    <span class="nav-link-text">Gerar faturamento</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Cadastrar usuários">
                <a class="nav-link" href="/auth/register">
                    <i class="fa fa-user-o" aria-hidden="true"></i>
                    <span class="nav-link-text">Cadastrar usuários</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                @guest
                <a href="/auth/login" class="nav-link" data-toggle="modal">
                    <i class="fa fa-fw fa-sign-out"></i>Entrar</a>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"
                           aria-haspopup="true">
                            <i class="fa fa-sign-in"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    <i class="fa fa-fw fa-sign-out"></i>
                                    Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
                </li>
        </ul>
    </div>
</nav>

<div class="content-wrapper">
    <div class="container-fluid">

        @if(Request::is('/') != 1)
            <div class="content-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="header-section text-center">
                            <h1>{{\Artesaos\SEOTools\Facades\SEOTools::metatags()->getTitleSession()}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div id="mensagem-aviso">
            @if(Session::has('info'))
                <div class="alert alert-info alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('info')}}
                </div>
            @endif

            @if(Session::has('warning'))
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('warning')}}
                </div>
            @endif

            @if(Session::has('sucesso'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{Session::get('sucesso')}}
                </div>
            @endif

            @if(Session::has('erro'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {!! nl2br(Session::get('erro')) !!}
                </div>
            @endif
        </div>
        </header><!--/header-->


        <section>
            <BR>
            @if ( $errors->any() )
                <ul class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach($errors->all() as $error)
                        <li> {{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="row">
                <div class="container">
                    @yield('conteudo')
                </div>
            </div>
        </section>


    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Desenvolvido por Mauricio T. Gomes, Jusimara Saccomori e Andressa Colla</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-mensagem-eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Atenção</h4>
                </div>
                <div class="modal-body text-center">
                    <p>Deseja realmente executar essa operação? <br> Ao executar essa ação não será possível
                        reverter.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnElimina" class="btn btn-success" data-dismiss="modal">Sim</button>
                    <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Não</button>
                </div>
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

    <link href="{{ asset('css/chosen/chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen/chosen.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('js/chosen/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('js/chosen/chosen.proto.js') }}"></script>
    <script src="{{ asset('js/ajax-loading.js') }}"></script>
    <script src="{{ asset('js/chosen/chosen.proto.min.js') }}"></script>

    <script>

        $('.select-chosen').chosen({
            width: '95%',
            allow_single_deselect: true,
            no_results_text: "Nenhum resultado encontrado!",
            placeholder_text_single: "Seleciona uma opção."
        });

        var linkURL;

        $(document).on('click', '#btnElimina', function () {
            return window.location.href = linkURL;
        });

        $(document).on('click', '.btn-confirm-operation', function (e) {
            e.preventDefault();
            linkURL = $(this).attr('href');
            $('#modal-mensagem-eliminar').modal();
        });
    </script>
</div>

</body>

</html>