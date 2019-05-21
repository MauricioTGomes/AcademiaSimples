@extends('index')
@section('conteudo')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content-wrapper">
        <div class="container-fluid">
            <h1>Resumo financeiro</h1>
            <hr>
            <div class="row">
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-50">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-comments"></i>
                            </div>
                            <div class="mr-5">
                                <br>
                                Resumo caixa:<br>
                                Valor contas receber: <br>
                                {{ $recebido }} <br>
                                Valor contas pagar: <br>
                                {{ $pago }} <br>
                                Total em caixa: <br>
                                {{ $caixa }}

                            </div>
                        </div>
                        {{--<a class="card-footer text-white clearfix small z-1" href="#">--}}
                            {{--<span class="float-left">Ver mais</span>--}}
                            {{--<span class="float-right">--}}
                {{--<i class="fa fa-angle-right"></i>--}}
              {{--</span>--}}
                        {{--</a>--}}
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-50">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-shopping-cart"></i>
                            </div>
                            <br>
                            <div class="mr-5">Total a receber do dia {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                                R$: {{ $receberDia }}<br>
                                Total à receber: <br>
                                R$: {{ $receberGeral }}<br>
                                Total recebido hoje: <br>
                                R$: {{ $recebidoDia }}
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('contas.receber.listar') }}">
                            <span class="float-left">Ver mais</span>
                            <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-danger o-hidden h-50">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fa fa-fw fa-support"></i>
                            </div>
                            <br>
                            <div class="mr-5">Total a pagar do dia {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                                R$: {{ $pagarDia }}
                                <br><br>
                                Total á pagar: <br>
                                R$: {{ $pagarGeral }}
                            </div>
                        </div>
                        <a class="card-footer text-white clearfix small z-1" href="{{ route('contas.pagar.listar') }}">
                            <span class="float-left">Ver mais</span>
                            <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>