var executaBuscaPacote = function (idPacote) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '/pacote/buscar/' + idPacote,
        data: idPacote,
        dataType: "json",
        complete: function (response) {
            $('#vlrPlano').val(response.responseJSON.vlr_total);
            $('#vlrDesconto').val('0,00');
            $('#vlrTotal').val(response.responseJSON.vlr_total);
        }
    });
};

var formatForCalc = function (vlr) {

    if (/null|undefined|Invalid|NaN/.test(vlr)) {
        return 0;
    }

    if (typeof vlr != "string") {
        vlr = vlr.toString();
    }
    if (vlr.length <= 6) {
        return parseFloat(vlr.replace(",", "."));
    }
    vlr = vlr.replace(".", "");
    vlr = vlr.replace(",", ".");
    return parseFloat(vlr);
};

$(document).ready(function () {

    $('#selectPacote').change(function () {
        executaBuscaPacote($(this).val());
    });


    $('#vlrDesconto').on('focusout', function () {
        if ($(this).val() != '') {
            var desconto = formatForCalc($(this).val()) || 0;
            var total = formatForCalc($('#vlrPlano').val()) - desconto;
            $('#vlrTotal').val(total.formatMoney(2, ',', '.'));
        }

        if ($(this).val() == '') {
            $(this).val('0,00').trigger('keyup');
        }
    });
});
