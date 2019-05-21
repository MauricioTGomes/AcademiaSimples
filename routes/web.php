<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */





Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

    Route::group(['prefix' => 'auth'], function () {
        Route::get('/login',['as'=>'login'], function () {return view('auth/login');});
        Route::post('/login', ['as' => 'logar', 'uses' => 'Auth\LoginController@authenticate']);
        Route::get('/register', ['uses'=>'IndexController@register']);
        Route::post('/gravar', ['uses'=>'IndexController@create']);
    });


    Route::group(['prefix' => 'pessoas'], function () {
        Route::get('/', ['as' => 'pessoas.listar', 'uses' => 'PessoaController@listar']);
        Route::get('/alterar/{id}', ['as' => 'pessoas.alterar', 'uses' => 'PessoaController@alterar']);
        Route::get('/incluir', ['as' => 'pessoas.incluir', 'uses' => 'PessoaController@incluir']);
        Route::post('/', ['as' => 'pessoas.gravar', 'uses' => 'PessoaController@gravar']);
        Route::post('/update/{id}', ['as' => 'pessoas.update', 'uses' => 'PessoaController@update']);
        Route::get('/listar/datatable', ['as' => 'pessoas.datatable', 'uses' => 'PessoaController@datatableAjax']);
        Route::get('/deletar/{id}', ['as' => 'pessoas.deletar', 'uses' => 'PessoaController@deletar']);
    });

    Route::group(['prefix' => 'pacote'], function () {
        Route::get('/', ['as' => 'pacote.listar', 'uses' => 'PacoteController@listar']);
        Route::get('/alterar/{id}', ['as' => 'pacote.alterar', 'uses' => 'PacoteController@alterar']);
        Route::get('/incluir', ['as' => 'pacote.incluir', 'uses' => 'PacoteController@incluir']);
        Route::post('/', ['as' => 'pacote.gravar', 'uses' => 'PacoteController@gravar']);
        Route::post('/update/{id}', ['as' => 'pacote.update', 'uses' => 'PacoteController@update']);
        Route::get('/deletar/{id}', ['as' => 'pacote.deletar', 'uses' => 'PacoteController@deletar']);
        Route::post('/buscar/{id}', ['as' => 'pacote.buscar', 'uses' => 'PacoteController@buscar']);
        Route::get('/listar/datatable', ['as' => 'pacote.datatable', 'uses' => 'PacoteController@datatableAjax']);

    });

    Route::group(['prefix' => 'contas/'], function () {
        Route::get('/deletar/{id}', ['as' => 'contas.deletar', 'uses' => 'ContaController@deletar']);
        Route::post('/gravar', ['as' => 'contas.gravar', 'uses' => 'ContaController@gravar']);
        Route::post('/update/{id}', ['as' => 'contas.update', 'uses' => 'ContaController@update']);
        Route::post('/parcela/calcular/', ['as' => 'parcelas.calcular', 'uses' => 'ContaController@calculaParcela']);
        Route::get('/parcela/{id}', ['as' => 'buscar.parcela', 'uses' => 'ParcelaController@buscaParcelas']);
        Route::post('/parcela/{id}', ['as' => 'baixar.parcela', 'uses' => 'ParcelaController@baixarParcela']);
        Route::post('/parcelaEstornar/{id}', ['as' => 'estornar.parcela', 'uses' => 'ParcelaController@estornoParcela']);
        Route::get('/estorno/{id}', ['as' => 'contas.estorno', 'uses' => 'ParcelaController@buscaParcelasEstorno']);

        Route::group(['prefix' => 'receber/'], function () {
            Route::get('', ['as' => 'contas.receber.listar', 'uses' => 'ContaController@listarReceber']);
            Route::get('incluir', ['as' => 'contas.receber.incluir', 'uses' => 'ContaController@getFormAdicionarReceber']);
            Route::get('/listar/datatable', ['as' => 'contas.receber.datatable', 'uses' => 'ContaController@datatableAjax']);
            Route::get('alterar/{id}', ['as' => 'contas.receber.alterar', 'uses' => 'ContaController@getFormAlterarReceber']);
            Route::get('detalhes/{id}', ['as' => 'contas.receber.detalhes', 'uses' => 'ContaController@getFormDetalhes']);
        });
        Route::group(['prefix' => 'pagar/'], function () {
            Route::get('', ['as' => 'contas.pagar.listar', 'uses' => 'ContaController@listarPagar']);
            Route::get('/listar/datatable', ['as' => 'contas.pagar.datatable', 'uses' => 'ContaController@datatableAjax']);
            Route::get('incluir', ['as' => 'contas.pagar.incluir', 'uses' => 'ContaController@getFormAdicionarPagar']);
            Route::get('alterar/{id}', ['as' => 'contas.pagar.alterar', 'uses' => 'ContaController@getFormAlterarPagar']);
            Route::get('detalhes/{id}', ['as' => 'contas.pagar.detalhes', 'uses' => 'ContaController@getFormDetalhes']);
        });

        Route::group(['prefix' => 'parcelas/'], function () {
            Route::post('/buscaParcelas', ['as' => 'parcelas.get', 'uses' => 'ParcelaController@buscaParcelas']);
            Route::post('/calcular', ['as' => 'parcelas.calcular', 'uses' => 'ParcelaController@calculaParcela']);
            Route::post('/baixar', ['as' => 'parcelas.baixar', 'uses' => 'ParcelaController@baixarParcela']);
            Route::post('/alteraCalculoJuros', ['as' => 'parcelas.calcular.juros', 'uses' => 'ParcelaController@alteraCalculoJuros']);
        });
        Route::group(['prefix' => 'estornos'], function () {
            Route::get('/', ['as' => 'estornos.index', 'uses' => 'EstornoController@getFormEstornos']);
            Route::get('/estornar/{id}', ['as' => 'estornos.executa', 'uses' => 'EstornoController@estornaRecebimento']);
            Route::get('/datatable/historicos', ['as' => 'estornos.datatable', 'uses' => 'EstornoController@datatableRecebimentoPagamento']);
        });
    });

    Route::group(['prefix' => 'pacotesCliente'], function () {
        Route::get('incluir/{id}', ['as' => 'pacotesCliente.incluir', 'uses' => 'PessoaPacoteController@getFormAdicionar']);
        Route::get('detalhes/{id}', ['as' => 'pacotesCliente.detalhes', 'uses' => 'PessoaPacoteController@detalhesPessoa']);
        Route::get('listar', ['as' => 'pacotesCliente.listar', 'uses' => 'PessoaPacoteController@listar']);
        Route::get('/deletar/{id}', ['as' => 'pacotesCliente.deletar', 'uses' => 'PessoaPacoteController@deletar']);
        Route::post('/', ['as' => 'pacotesCliente.gravar', 'uses' => 'PessoaPacoteController@gravar']);
        Route::get('/listar/datatable/{id}', ['as' => 'pacotesCliente.datatable', 'uses' => 'PessoaPacoteController@datatableAjax']);
    });

    Route::group(['prefix' => 'faturamento'], function () {
        Route::get('/', ['as' => 'faturamento.listar', 'uses' => 'FaturaController@listar']);
        Route::post('/buscar', ['as' => 'faturamento.buscar', 'uses' => 'FaturaController@buscaContratos']);
        Route::post('/faturar', ['as' => 'faturamento.faturar', 'uses' => 'FaturaController@faturaClientes']);
    });
    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
