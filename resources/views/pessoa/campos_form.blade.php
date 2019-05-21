<div class="w3-container w3-light-grey">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4 col-xs-6">
                    <label class="csscheckbox csscheckbox-danger">
                        {!! Form::checkbox('cliente', 1,isset($registro) ? $registro->cliente:1)!!}
                        <span></span>&nbsp;
                        &nbsp;
                        Cliente
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label class="csscheckbox csscheckbox-danger">
                        {!! Form::checkbox('fornecedor', 1,isset($registro) ? $registro->fornecedor:0)!!}
                        <span></span>&nbsp;
                        &nbsp;
                        Fornecedor
                    </label>
                </div>
                <div class="col-sm-4 col-xs-6">
                    <label class="csscheckbox csscheckbox-danger">
                        {!! Form::checkbox('funcionario', 1,isset($registro) ? $registro->funcionario:0, ['class'=>'pessoas checkbox-funcionario'])!!}
                        <span></span>&nbsp;
                        &nbsp;
                        Funcionário
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="tipo">Tipo <i class="text-danger" title="Campo obrigatório">*</i></label>
                {!! Form::select('tipo', ['1'=>'Físico','2'=>'Jurídico'], isset($registro) ? $registro->tipo:null, ['class'=>'select-chosen pessoas select-tipo form-control', 'id'=>'tipo-pessoa']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="sexo">Sexo <i class="text-danger" title="Campo obrigatório">*</i></label>
                {!! Form::select('sexo', ['Masculino'=>'Masculino','Feminino'=>'Feminino'],null, ['class'=>'select-chosen form-control']) !!}
            </div>
        </div>
    </div>

    <div class="form-fisico">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="nome">Nome <i class="text-danger" title="Campo obrigatório">*</i></label>
                    {!! Form::text('nome', null, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    {!! Form::text('cpf', isset($registro) ? $registro->cpf : null,['class'=>'input-cpf form-control','id'=>'cpf-pessoa']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="rg">RG</label>
                    {!! Form::text('rg', null, ['class'=>'form-control']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="form-juridico">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="cnpj">CNPJ</label>
                    <div class="input-group">
                        {!! Form::text('cnpj', null, ['class'=>'input-cnpj form-control', 'id'=>'cnpj']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label for="razao_social">Razão social <i class="text-danger"
                                                              title="Campo obrigatório">*</i></label>
                    {!! Form::text('razao_social', null, ['class'=>'form-control', 'id'=>'razao_social']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="fantasia">Fantasia <i class="text-danger" title="campo obrigatório">*</i></label>
                    {!! Form::text('fantasia', null, ['class'=>'form-control', 'id'=>'fantasia']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="cep">Inscrição estadual</label>
                    <div class="input-group">
                        {!! Form::text('ie', null, ['class'=>'form-control input-positive3']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="fone">Telefone(s) <i class="text-danger" title="Campo obrigatório">*</i></label>
                {!! Form::text('fone', null, ['class'=>'input-fone form-control']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="email">E-mail</label>
                {!! Form::text('email', null, ['type'=>'email', 'class'=>'input-email form-control', 'id'=>'email']) !!}
            </div>
        </div>
    </div>

    <h3>Endereço</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="cep">CEP</label>
                <div class="input-group">
                    {!! Form::text('cep', null, ['class'=>'input-cep form-control', 'id'=>'cep_endereco']) !!}
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label for="endereco">Endereço <i class="text-danger" title="campo obrigatório">*</i></label>
                {!! Form::text('endereco', null, ['class'=>'form-control', 'id'=>'endereco']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="endereco_nro">Número <i class="text-danger" title="campo obrigatório">*</i></label>
                {!! Form::text('endereco_nro', null, ['class'=>'input-positive form-control', 'id'=>'nro_endereco']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="cidade">Cidade <i class="text-danger" title="campo obrigatório">*</i></label>
                {!! Form::text('cidade', null, ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('complemento','Complemento') !!}
                {!! Form::text('complemento', null, ['class'=>'form-control']) !!}
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="bairro">Bairro <i class="text-danger" title="campo obrigatório">*</i></label>
                {!! Form::text('bairro', null, ['class'=>'form-control', 'id'=>'bairro']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group form-actions">
                {!! Form::submit('Salvar pessoa', ['class'=> 'btn-submit btn btn-effect-ripple btn-success']) !!}
                <a href="{{route('pessoas.listar')}}" class="btn btn-effect-ripple btn-danger">Cancelar</a>
            </div>
        </div>
    </div>
</div>
<script src="{{ elixir('js/jquery-2.2.0.min.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#tipo-pessoa').change(function () {
            controlaPessoa($(this).val());
        });
    });

    var controlaPessoa = function (valor) {
        if (valor == 1) {
            $('.form-juridico').css('display', 'none');
            $('.form-fisico').css('display', 'block');
        }
        if (valor == 2) {
            $('.form-juridico').css('display', 'block');
            $('.form-fisico').css('display', 'none');
        }
    };
    controlaPessoa($('#tipo-pessoa').val());
</script>