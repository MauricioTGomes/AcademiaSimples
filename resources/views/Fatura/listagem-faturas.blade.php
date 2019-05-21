@extends('index')
@section('conteudo')

    <div class="fatura">

        @if(count($clientesFatura))

            <form method="POST" action="{{ route('faturamento.faturar') }}"
                  class="form-seleciona-contratos-faturar">

                {{ csrf_field() }}



                <div class="card mb-6">
                    <div class="card-header">
                        <i class="fa fa-table"></i> Cliente à faturar
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="25%">Pessoa</th>
                                    <th width="10%">Dia cobrança</th>
                                    <th width="15%" class="text-center">Valor (R$)</th>
                                    <th width="8%" class="text-center">Faturar</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clientesFatura as $clienteFatura)
                                    <tr class="contrato">
                                        <td>
                                            {{ $clienteFatura->pessoa->nome == '' ? $clienteFatura->pessoa->fantasia : $clienteFatura->pessoa->nome }}
                                        </td>
                                        <td>
                                            {{$clienteFatura->dia_cobranca}}
                                        </td>
                                        <td class="text-center">
                                            {{ $clienteFatura->vlr_total }}
                                        </td>
                                        <td class="text-center">
                                            <label class="csscheckbox csscheckbox-danger">
                                                <input type="checkbox" name="faturamento[{{$clienteFatura->id}}]"
                                                       checked=""
                                                       data-custom-tipo-documento="{{ $clienteFatura->dia_cobranca }}"
                                                       class="faturar">
                                                <span></span>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Tabela faturamento</div>
                </div>
                <br>
                <button type="submit" class="btn btn-success">Faturar clientes</button>
                <a href="/faturamento" class="btn btn-effect-ripple btn-danger">Cancelar</a>
            </form>

        @else
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h4>Nenhum cliente pendente para faturamento nesta data!</h4>
                </div>
            </div>
            <a href="/" class="btn btn-danger"> Voltar </a>
        @endif
    </div>
    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>
        $(function () {
            $('#dataTable').DataTable({
                 "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });
    </script>
@endsection