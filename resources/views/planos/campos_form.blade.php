<div class="w3-container w3-light-grey">
    <div class="row">
        <input type="hidden" value="{{ isset($pessoa) ? $pessoa->id : null }}" name="pessoa_id">

        <div class="col-sm-4">
            <label for="pacote_id">Pacotes<i class="text-danger" title="Campo obrigatório">*</i></label>
            <select name="pacote_id" id="selectPacote" class="select-chosen select-pessoa form-control">
                @foreach($pacotes as $pacote)
                    <option value="{{ $pacote->id }}">{{ $pacote->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="dia_cobranca">Dia de vencimento<i class="text-danger"
                                                              title="campo obrigatório">*</i></label>
                {!! Form::text('dia_cobranca', null, ['class'=>'input-positive form-control', 'id'=>'diaCobranca', 'maxlength'=>'2']) !!}
            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-table"></i> Pacote selecionado
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered tablePacotes" id="dataTable" width="100%" cellspacing="0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vlr_plano">Valor planos</label>
                                {!! Form::text('vlr_plano', null, ['class'=>'input-money form-control', 'id'=>'vlrPlano', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vlr_desconto">Valor desconto</label>
                                {!! Form::text('vlr_desconto', null, ['class'=>'input-money form-control', 'id'=>'vlrDesconto']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="vlr_total">Valor total</label>
                                {!! Form::text('vlr_total', null, ['class'=>'input-money form-control', 'id'=>'vlrTotal', 'readonly']) !!}
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Tabela pacotes</div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="form-group form-actions">
            {!! Form::submit('Salvar pessoa', ['class'=> 'pessoas btn-submit-form btn btn-effect-ripple btn-success']) !!}
            <a href="{{route('pessoas.listar')}}" class="btn btn-effect-ripple btn-danger">Cancelar</a>
        </div>
    </div>
</div>

<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
<script type="text/javascript">
        $('#selectPacote').val([]);
</script>