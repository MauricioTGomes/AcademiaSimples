@extends('index')
@section('conteudo')

    <form action="{{ route("faturamento.buscar") }}" method="POST">
        <div class="block">
            <div class="block-title">
                <h3>Faturar clientes</h3>
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="dia_cobranca">Dia de cobrança<i class="text-danger"
                                                                    title="Campo obrigatório">*</i></label>
                        {!! Form::text('dia_cobranca', null, ['class'=>'input-data input-positive form-control', 'maxlength'=>'2']) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Buscar clientes</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
@endsection
