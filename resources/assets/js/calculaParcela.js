var insereHtml = function (retorno, tbody) {
    tbody.html('');

    $.each(retorno, function (key, parcela) {
        tbody.append(
            "<tr>" +
            "<td>" +
            "<input type='text' class='input-index-parcela form-control' readonly name='array_parcela[" + key + "][nro_parcela]' value='" + parcela.nro_parcela + "'/>" +
            "</td>" +
            "<td>" +
            "<div class='form-group'>" +
            "<input class='input-data-parcela dtpick-par form-control' type='text' name='array_parcela[" + key + "][data_vencimento]' value='" + parcela.data_vencimento + "'/>" +
            "</div>" +
            "</td>" +
            "<td>" +
            "<div class='form-group'>" +
            "<input type='text' class='input-valor-parcela input-money form-control' name='array_parcela[" + key + "][valor]' value='" + parcela.valor + "'/>" +
            "</div>" +
            "</td>"
        );
    });
};

var executaCalculoForm = function () {

    var data = {
        vlr_total: $('div.faturamento .input-valor-pago').val(),
        qtd_parcelas: $('div.faturamento .input-qtd-parcelas').val(),
        qtd_dias: $('div.faturamento .input-qtd-dias').val(),
        data_emissao: $('div.faturamento .input-data-emissao').val()
    };

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"POST",
        url: '/contas/parcela/calcular',
        data: data,
        dataType:"json",
        complete:function(response){
            insereHtml(response.responseJSON, $('.tbody-parcelas'));
        }
    });
};

$('#js-btnCalculaParcelasConta').click(function () {
       executaCalculoForm();
});
