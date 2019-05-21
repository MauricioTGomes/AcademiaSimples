@extends('index')
@section('conteudo')

    {{ csrf_field() }}

    <div class="card mb-6">
        <div class="card-header">
            <i class="fa fa-table"></i> Parcelas
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%">Número parcela</th>
                        <th width="20%">Data vencimento</th>
                        <th width="20%">Data da baixa</th>
                        <th width="20%" class="text-center">Valor (R$)</th>
                        <th width="8%" class="text-center">Estornar parcela</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($parcelas))
                        @foreach($parcelas as $parcela)
                            <tr class="contrato">
                                <td>
                                    {{ $parcela->nro_parcela }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($parcela->data_recebimento)->format('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    {{ $parcela->valor }}
                                </td>
                                <td class="text-center">
                                    <input type="hidden" value="{{ $parcela->id }}" name="parcela_id">
                                    <a data-href="{{ route('estornar.parcela',['id'=>$parcela->id]) }}"
                                       data-id="{{$parcela->id}}"
                                       class="btn btn-effect-ripple btn-success btnBaixaParcela">
                                        <i class="fa fa-undo"></i> Estornar
                                    </a>
                                </td>
                            </tr>
                    @endforeach
                    @else
                        <tbody class="tbody-parcelas">
                        <tr>
                            <td colspan="3" class="text-center">Parcelas não encontradas</td>
                        </tr>
                        </tbody>
                        @endif
                        </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Tabela faturamento</div>
    </div>
    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <div class="modal fade" id="modal-mensagem">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" name="tipo_conta">
                <div class="modal-header">
                    <h4 class="modal-title">Sucesso</h4>
                </div>
                <div class="modal-body text-center">
                    <p>Estorno realizada com sucesso!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnFecharModal" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>



    <script>

        $('.btnBaixaParcela').click(function () {
            executaAjax($(this).attr('data-href'));

        });

        $('#btnFecharModal').click(function () {
                location.href = "/contas/" + $('input[name="tipo_conta"]').val();
        });

        var executaAjax = function (_url) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: _url,
                dataType: "json",
                complete: function (response) {
                    $('input[name="tipo_conta"]').val(response.responseJSON.tipo);
                    $('#modal-mensagem').modal();
                }
            });
        };

        $(function () {
            $('#dataTable').DataTable({
                "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });
    </script>
@endsection