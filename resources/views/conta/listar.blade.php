@extends('index')
@section('conteudo')
    <div class="card mb-6">
        <div class="card-header">
            @if (substr($_SERVER['REQUEST_URI'], 8, 7) == 'receber')
                <a href="{{ route('contas.receber.incluir') }}" class="btn btn-effect-ripple btn-success">
                    <i class="fa fa-plus"></i> Adicionar conta
                </a>
            @else
                <a href="{{ route('contas.pagar.incluir') }}" class="btn btn-effect-ripple btn-success">
                    <i class="fa fa-plus"></i> Adicionar conta
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="10%">Título</th>
                        <th width="10%">Data emissão</th>
                        <th width="20%">Nome</th>
                        <th width="15%">Valor (R$)</th>
                        <th width="15%">Ações</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Tabela contas</div>
    </div>
    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ elixir('js/controlaForm.js') }}"></script>

    <script>
        $(function () {
            var _url = null;
            if(location.href.slice(29,34) == "pagar") {
                _url = '{{route('contas.pagar.datatable')}}';
            } else {
                _url = '{{route('contas.receber.datatable')}}';
            }

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: _url
                },
                columns: [
                    {data: 'titulo', name: 'titulo'},
                    {data: 'data_emissao', name: 'data_emissao'},
                    {data: 'pessoa', name: 'pessoa'},
                    {data: 'vlr_total', name: 'vlr_total'},
                    {data: 'action', name: 'Ações', orderable: false, searchable: false}
                ], "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });

    </script>


@endsection