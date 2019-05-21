<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <title>Acadêmia corpo e movimento</title>

</head><!--/head-->

<body>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> (54) 9621-8195</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> mauricio@rbrinformatica.com.br</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="/"><span>Nome academia</span></a>
                    </div>

                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-money"></i>Contas</a></li>
                            <li><a href="{{ route('pessoas.listar') }}"><i class="fa fa-crosshairs"></i> Listar cliente</a>
                            </li>
                            <li><a href="{{ route('pacote.listar') }}"><i class="fa fa-shopping-cart"></i> Listar
                                    pacotes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li class="dropdown"><a href="{{ route('contas.receber.listar') }}">Contas Receber<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{ route('contas.receber.listar') }}">Listar</a></li>
                                    <li><a href="{{ route('contas.receber.incluir') }}">Lançar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="{{ route('contas.pagar.listar') }}">Contas Pagar<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{ route('contas.pagar.listar') }}">Listar</a></li>
                                    <li><a href="{{ route('contas.pagar.incluir') }}">Lançar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="{{ route('pacote.listar') }}">Pacotes<i
                                            class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{ route('pacote.listar') }}">Listar</a></li>
                                    <li><a href="{{ route('pacote.incluir') }}">Cadastrar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="{{ route('pessoas.listar') }}">Pessoas<i
                                            class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{ route('pessoas.listar') }}">Listar</a></li>
                                    <li><a href="{{ route('pessoas.incluir') }}">Cadastrar</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="{{ route('pessoas.listar') }}">Gerar faturamento</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--/header-bottom-->
        </div>
    </div>
    <div class="content-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="header-section text-center">
                    <h1>{{\Artesaos\SEOTools\Facades\SEOTools::metatags()->getTitleSession()}}</h1>
                </div>
            </div>
        </div>
    </div>
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
    <div class="row">
        <div class="container">
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            @yield('conteudo')
        </div>
    </div>
    <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <ul class="list-inline item-details">
                <li><a href="http://themifycloud.com">ThemifyCloud</a></li>
                <li><a href="http://themescloud.org">ThemesCloud</a></li>
            </ul>
        </div>
    </div>
</section>

<footer id="footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Desenvolvidor por Mauricio Treviso Gomes.</p>
                <p class="pull-right">E-mail para contato: mauricio@rbrinformatica.com.br</p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->

    <script src="{{ elixir('js/all.js') }}"></script>
    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>

</body>
</html>