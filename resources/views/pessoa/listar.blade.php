@extends('index')
@section('conteudo')

    <div class="card mb-6">
        <div class="card-header">
            <a href="{{ route('pessoas.incluir') }}" class="btn btn-effect-ripple btn-success">
                <i class="fa fa-plus"></i>
                Adicionar pessoa
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="42%">Nome / Razão Social</th>
                        <th width="22%">CPF / CNPJ</th>
                        <th width="18%">Telefone</th>
                        <th width="18%">Ações</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Table pessoas</div>
    </div>

    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>
        $(function () {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('pessoas.datatable')}}'
                },
                columns: [
                    {data: 'nome', name: 'nome'},
                    {data: 'cpf', name: 'cpf'},
                    {data: 'fone', name: 'fone'},
                    {data: 'action', name: 'Ações', orderable: false, searchable: false}
                ], "language": {
                    "url": '{{asset('js/vendor/datatables/DataTable-pt-BR.json')}}'
                }
            });
        });
    </script>

@endsection