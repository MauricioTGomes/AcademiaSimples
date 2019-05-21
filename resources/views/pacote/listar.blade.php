@extends('index')
@section('conteudo')


    <div class="card mb-6">
        <div class="card-header">
            <a href="{{ route('pacote.incluir') }}" class="btn btn-effect-ripple btn-success">
                <i class="fa fa-plus"></i>
                Adicionar pacote
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="25%">Nome</th>
                        <th width="25%">Observações</th>
                        <th width="25%">Valor (R$)</th>
                        <th width="25%">Ações</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Table pacotes</div>
    </div>

    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>
        $(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('pacote.datatable')}}'
                },
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'observacoes', name: 'observacoes'},
                    {data: 'vlr_total', name: 'vlr_total'},
                    {data: 'action', name: 'Ações', orderable: false, searchable: false}
                ], "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });
    </script>


@endsection