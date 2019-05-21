@extends('index')
@section('conteudo')

    <div class="card mb-3">
        <div class="card-header">
            <a href="{{ route('pacotesCliente.incluir', ['id'=>$pessoa->id]) }}" class="btn btn-effect-ripple btn-success">
                <i class="fa fa-plus"></i>
                Lançar pacote ao cliente
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-pessoaPacote" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="25%">Nome</th>
                        <th width="25%">Dia de cobrança</th>
                        <th width="25%">Valor total (R$)</th>
                        <th width="25%">Ações</th>
                    </tr>
                    </thead>

                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Tabela planos cliente</div>
    </div>

    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>

        $(function () {
            $('#table-pessoaPacote').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('pacotesCliente.datatable', ['id'=>$pessoa->id])}}'
                },
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'dia_cobranca', name: 'dia_cobranca'},
                    {data: 'vlr_total', name: 'vlr_total'},
                    {data: 'action', name: 'Ações', orderable: false, searchable: false}
                ], "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });
    </script>

@endsection