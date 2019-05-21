<div class="w3-container w3-light-grey">

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="nome">Nome</label>
                {!! Form::text('nome', null, ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="vlr_total">Valor do pacote</label>
                {!! Form::text('vlr_total', isset($registro) ? $registro->vlr_total : '0,00',['class'=>'input-money form-control']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="observacoes">Observações</label>
                {!! Form::text('observacoes', null, ['class'=>'form-control']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group form-actions">
                {!! Form::submit('Salvar pacote', ['class'=> 'pessoas btn-submit-form btn btn-effect-ripple btn-success']) !!}
                <a href="{{route('pacote.listar')}}" class="btn btn-effect-ripple btn-danger">Cancelar</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>

<script>
    $('#js-pessoa').val([]);
</script>