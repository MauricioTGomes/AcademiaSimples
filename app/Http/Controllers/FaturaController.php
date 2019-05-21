<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Parcela;
use App\PessoaPacote;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FaturaController extends Controller
{

    private $pessoaPacoteModel;
    private $contaModel;
    private $parcelaModel;

    public function __construct(PessoaPacote $pessoaPacoteModal, Parcela $parcelaModel, Conta $contaModel)
    {
        $this->middleware('auth');
        $this->pessoaPacoteModel = $pessoaPacoteModal;
        $this->contaModel = $contaModel;
        $this->parcelaModel = $parcelaModel;
    }


    public function listar()
    {
        SEOTools::setTitle('Listar pessoas');
        return view('Fatura/listar');
    }

    public function buscaContratos(Request $request)
    {
        $clientesFatura = $this->pessoaPacoteModel->newQuery()
            ->where('mes_faturado', '!=', Carbon::now()->format('m'))
            ->orWhere('mes_faturado', null)
            ->where('dia_cobranca', '<=', $request->input('dia_cobranca'))->get();
        SEOTools::setTitle("Clientes à faturar");
        return view('Fatura.listagem-faturas', compact('clientesFatura'));
    }

    public function faturaClientes(Request $request)
    {
        try {
            DB::beginTransaction();
            $clientesFaturar = $request->input('faturamento');
            if (is_null($clientesFaturar)) {return redirect()->route("faturamento.listar")->with(['sucesso' => "Favor selecionar pelo menos um cliente."]);}
            foreach ($clientesFaturar as $idFaturar => $infoFatura) {
                $pacoteFaturar = $this->pessoaPacoteModel->find($idFaturar);
                $arrayConta = [
                    'pessoa_id' => $pacoteFaturar->pessoa_id,
                    'titulo' => 'Faturamento',
                    'data_emissao' => Carbon::now(),
                    'vlr_total' => $pacoteFaturar->vlr_total,
                    'qtd_parcelas' => '1',
                    'tipo_operacao' => 'R',
                    'qtd_dias' => '1'
                ];
                $conta = Conta::create($arrayConta);

                $arrayParcela = [
                    'nro_parcela' => '1',
                    'valor' => $pacoteFaturar->vlr_total,
                    'valor_original' => $pacoteFaturar->vlr_total,
                    'valor_restante' => $pacoteFaturar->vlr_total,
                    'data_vencimento' => $pacoteFaturar->dia_cobranca,
                    'baixada' => '0',
                    'conta_id' => $conta->id
                ];
                Parcela::create($arrayParcela);
                $pacoteFaturar->mes_faturado = Carbon::now()->format('m');
                $pacoteFaturar->save();
            }
            DB::commit();
            return redirect()->route("contas.receber.listar")->with(['sucesso' => "Faturamento realizado com ssucesso."]);
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

}