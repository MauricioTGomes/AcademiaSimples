/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(43);


/***/ }),

/***/ 43:
/***/ (function(module, exports) {

calculaParcela = function () {

    var atualizaValorParcelas = function atualizaValorParcelas(inputEvent, tbody) {

        var valorTotalConta = formatForCalc($('.faturamento .input-valor-pago').val());
        var diferenca = 0;
        var valor = 0;
        var valorSomaParcelas = 0;
        var inputsValor = tbody.find('.input-valor-parcela');
        var ultimoInputValor = $('.input-valor-parcela:last');

        //faz uma soma do valor das parcelas
        inputsValor.each(function (index, domElement) {
            valorSomaParcelas += formatForCalc($(domElement).val());
        });

        if (valorTotalConta > valorSomaParcelas) {
            diferenca = valorTotalConta - valorSomaParcelas;
            ultimoInputValor.val((formatForCalc(ultimoInputValor.val()) + diferenca).formatMoney(2, ',', '.'));
        }

        if (valorSomaParcelas > valorTotalConta) {
            diferenca = valorSomaParcelas - valorTotalConta;
            ultimoInputValor.val((formatForCalc(ultimoInputValor.val()) - diferenca).formatMoney(2, ',', '.'));
        }
    };

    var insereHtml = function insereHtml(retorno, tbody) {
        tbody.html('');
        $.each(retorno, function (key, parcela) {
            tbody.append("<tr>" + "<td>" + "<input type='text' class='input-index-parcela form-control' readonly name='array_parcela[" + key + "][nro_parcela]' value='" + parcela.nro_parcela + "'/>" + "</td>" + "<td>" + "<div class='form-group'>" + "<input class='input-data-parcela dtpick-par form-control' type='text' name='array_parcela[" + key + "][data_vencimento]' value='" + parcela.data_vencimento + "'/>" + "</div>" + "</td>" + "<td>" + "<div class='form-group'>" + "<input type='text' class='input-valor-parcela input-money form-control' name='array_parcela[" + key + "][valor]' value='" + parcela.valor + "'/>" + "</div>" + "</td>");
        });

        $('.dtpick-par').datepicker({
            weekStart: 1,
            language: 'pt-BR',
            autoclose: true
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
        });

        ObjRBR.object.Mask.adicionaMascara();
    };

    return {
        executaCalculo: function executaCalculo(arrayInput) {

            if (FormsValidation.validaArrayCampo(arrayInput)) {
                var ajax = new ObjRBR.Services.Ajax();
                ajax.url = "/contas/parcelas/calcular";
                ajax.data = {
                    vlr_total: arrayInput.vlr_total.val(),
                    qtd_parcelas: arrayInput.qtd_parcelas.val(),
                    qtd_dias: arrayInput.qtd_dias.val(),
                    data_emissao: arrayInput.data_emissao.val(),
                    forma_pagamento_id: arrayInput.forma_pagamento != undefined ? arrayInput.forma_pagamento.val() : null,
                    url: window.location.pathname
                };
                return ajax.getPromisse();
            }
        },

        executaCalculoForm: function executaCalculoForm() {

            var formaPagamento = $('div.faturamento input.forma-pagamento-id');

            var data = {
                vlr_total: $('div.faturamento .input-valor-pago'),
                qtd_parcelas: $('div.faturamento .input-qtd-parcelas'),
                qtd_dias: $('div.faturamento .input-qtd-dias'),
                data_emissao: $('div.faturamento .input-data-emissao')
            };

            if (formaPagamento.val() != '') {
                data.forma_pagamento = formaPagamento;
            }

            var promisse = ObjRBR.Services.CalculaParcelas.executaCalculo(data);

            if (promisse != null) {
                promisse.then(function (response) {
                    if (response.erro == 1) {
                        ObjRBR.Services.SwallService.simple("Atenção!", response.stack, 'error');
                        $('div.faturamento .tbody-parcelas').html('');
                        return null;
                    }
                    mostraParcelas(response);
                });
            }
        }
    };
}();

/***/ })

/******/ });