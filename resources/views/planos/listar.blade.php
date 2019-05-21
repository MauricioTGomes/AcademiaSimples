@extends('index')
@section('conteudo')

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="pessoa_id">Pessoa<i class="text-danger" title="Campo obrigatório">*</i></label>
                <select name="pessoa_id" id="js-pessoa" class="select-pessoa select-chosen form-control">
                    @foreach($pessoas as $pessoa)
                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome == '' ? $pessoa->fantasia . ' - ' . $pessoa->razao_social : $pessoa->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <br>
            <div class="form-group">
                <a id="js-addPlanoPessoa" class="btn btn-effect-ripple btn-success">
                    <i class="fa fa-plus"></i>
                    Lançar plano ao cliente
                </a>
            </div>
        </div>
    </div>
    <script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
    <script src="{{ elixir('js/app.js') }}"></script>

    <script>

        $(document).ready(function () {
            $('.select-pessoa').change(function () {
                $('#js-addPlanoPessoa').attr('href', '/pacotesCliente/incluir/' + $(this).val());
            });
        });

        $('.select-pessoa').val([]);
    </script>


@endsection