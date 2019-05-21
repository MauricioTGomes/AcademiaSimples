<div class="faturamento">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="titulo">Título<i class="text-danger" title="Campo obrigatório">*</i></label>
                {!! Form::text('titulo', null, ['class'=>'form-control']) !!}
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="data_emissao">Data de emissão <i class="text-danger" title="Campo obrigatório">*</i></label>
                {!! Form::text('data_emissao', date('d/m/Y'), ['class'=>'input-data-emissao input-data form-control', 'title'=>'Data de emissão']) !!}
            </div>
        </div>
    </div>

    <div id="div-valores-conta">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="vlr_total">Valor da conta <i class="text-danger" title="Campo obrigatório">*</i></label>
                    {!! Form::text('vlr_total', null, ['class'=>'input-valor-pago input-money form-control', 'title'=>'Valor da conta']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="qtd_parcelas">Número de parcelas <i class="text-danger" title="Campo obrigatório">*</i></label>
                    {!! Form::text('qtd_parcelas', isset($conta) ? $conta->qtd_parcelas : 3, ['class'=>'input-qtd-parcelas input-positive form-control', 'title'=>'Número de parcelas', 'min' => '0']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="qtd_dias">Dias entre as parcelas <i class="text-danger" title="Campo obrigatório">*</i></label>
                    {!! Form::text('qtd_dias', isset($conta) ? $conta->qtd_dias : 30, ['class'=>'input-qtd-dias input-positive form-control', 'title'=>'Dias entre as parcelas', 'min' => '0']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <a id="js-btnCalculaParcelasConta" class="btn btn-effect-ripple btn-success btn-sm">Calcular
                    parcelas</a>
            </div>
        </div>
    </div>


    <div class="card mb-6">
        <div class="card-header">
            <i class="fa fa-table"></i>Parcelas</div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="33%">Parcela</th>
                        <th width="33%">Data</th>
                        <th width="33%">Valor (R$)</th>
                    </tr>
                    </thead>
                    <tbody class="tbody-parcelas">
                    <tr>
                        <td colspan="3" class="text-center">Parcelas não calculadas</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Table parcelas</div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('observacao','Observação') !!}
                {!! Form::textarea('observacao', null, ['class'=>'form-control', 'rows'=>'2']) !!}
            </div>
        </div>
    </div>
</div>
<script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>
<script type="text/javascript">
    $('.select-pessoa').val([]);
</script>