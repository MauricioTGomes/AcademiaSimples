<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Parcela;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class ParcelaController extends Controller
{

    private $parcelaModel;
    private $contaModel;

    public function __construct(Parcela $parcelaModel, Conta $contaModel) {
        $this->parcelaModel = $parcelaModel;
        $this->contaModel = $contaModel;
    }

    function formatValueForMysql($valor)
    {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function baixarParcela($id, Request $request) {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $desconto = $this->formatValueForMysql(array_keys($input)[0]);
            $parcela = $this->parcelaModel->find($id);
            $parcela->valor_pago = $parcela->valor - $desconto;
            $parcela->data_recebimento = Carbon::now()->format('Y-m-d');
            $parcela->valor_desconto = $desconto;
            $parcela->baixada = 1;
            $parcela->save();
            $parcela->conta->save();
            DB::commit();
            return response()->json(['erro' => 0, 'msg' => 'Baixa realizada com sucesso!', 'tipo' => $parcela->conta->tipo_operacao == 'P' ? 'pagar' : 'receber']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['erro' => 1, 'msg' => $e->getMessage()]);
        }
    }

    public function estornoParcela($id){
        try {
            DB::beginTransaction();
            $parcela = $this->parcelaModel->find($id);
            $parcela->valor_pago = '0.00';
            $parcela->valor_desconto = '0.00';
            $parcela->data_recebimento = null;
            $parcela->baixada = 0;
            $parcela->save();
            DB::commit();
            return response()->json(['erro' => 0, 'tipo' => $parcela->conta->tipo_operacao == 'P' ? 'pagar' : 'receber']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['erro' => 1, 'msg' => $e->getMessage()]);
        }
    }

    function formatValueForUser($valor)
    {
        if (empty($valor)) {
            return '0,00';
        }
        return number_format($valor, 2, ',', '.');
    }

    public function buscaParcelasEstorno($id) {
        try {
            $parcelas = $this->parcelaModel->newQuery()->where('conta_id', $id)->where('baixada', 1)->get();
            $modalConta = new Conta();
            $conta = $modalConta->find($id);
            if (count($parcelas) == 0) {
                return redirect()->route('contas.' . ($conta->tipo_operacao == 'R' ? 'receber' : 'pagar') . '.listar')->with(['sucesso' => 'Conta com todas as parcelas abertas.']);
            }
            SEOTools::setTitle('Parcelas da conta de título ' . $parcelas->first()->conta->titulo);
            return view('conta.listar-parcela-estornar', compact('parcelas'));
        } catch (\Exception $e) {
            return response()->json(['sucess' => 1, 'msg' => $e->getMessage()]);
        }
    }

    public function buscaParcelas($id){
        try {
            $parcelas = $this->parcelaModel->newQuery()->where('conta_id', $id)->where('baixada', 0)->get();
            $modalConta = new Conta();
            $conta = $modalConta->find($id);
            if (count($parcelas) == 0) {
                return redirect()->route('contas.' . ($conta->tipo_operacao == 'R' ? 'receber' : 'pagar') . '.listar')->with(['sucesso' => 'Conta com todas parcelas baixadas.']);
            }
            SEOTools::setTitle('Parcelas da conta de título ' . $parcelas->first()->conta->titulo);
            return view('conta.listar-parcela', compact('parcelas'));
        } catch (\Exception $e) {
            return response()->json(['sucess' => 1, 'msg' => $e->getMessage()]);
        }
    }

}