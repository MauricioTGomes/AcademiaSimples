<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Http\Requests\PessoaPacoteRequest;
use App\Pacote;
use App\Parcela;
use App\Pessoa;
use App\PessoaPacote;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use League\Flysystem\Exception;
use Yajra\DataTables\Facades\DataTables;

class PessoaPacoteController extends Controller
{

    private $contaModel;
    private $pessoaModel;
    private $parcelaModel;
    private $pessoaPacoteModal;
    private $pacoteModal;

    public function __construct(Pacote $pacoteModal, PessoaPacote $pessoaPacoteModal, Conta $contaModel, Pessoa $pessoaModel, Parcela $parcelaModel)
    {
        $this->middleware('auth');
        $this->pacoteModal = $pacoteModal;
        $this->contaModel = $contaModel;
        $this->parcelaModel = $parcelaModel;
        $this->pessoaModel = $pessoaModel;
        $this->pessoaPacoteModal = $pessoaPacoteModal;
    }

    public function detalhesPessoa($idPessoa)
    {
        $pessoa = $this->pessoaModel->find($idPessoa);
        SEOTools::setTitle('Pacotes do cliente ' . ($pessoa->nome == '' ? $pessoa->fantasia : $pessoa->nome));
        return view('planos.detalhes', compact('pessoa'));
    }

    public function listar()
    {
        SEOTools::setTitle('Lançar plano cliente');
        $pessoas = $this->pessoaModel->newQuery()->where('cliente', 1)->get();
        return view('planos/listar', compact('pessoas'));
    }

    public function getFormAdicionar($idPessoa)
    {
        $pessoa = $this->pessoaModel->find($idPessoa);
        SEOTools::setTitle('Adicionar pacotes ao cliente ' . ($pessoa->nome == '' ? $pessoa->fantasia : $pessoa->nome));
        $pacotes = $this->pacoteModal->all();
        return view('planos.adicionar', compact('pacotes', 'pessoa'));
    }

    function formatValueForMysql($valor)
    {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function gravar(PessoaPacoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['vlr_total'] = $this->formatValueForMysql($input['vlr_total']);
            $input['vlr_desconto'] = $this->formatValueForMysql($input['vlr_desconto']);
            PessoaPacote::create($input);
            DB::commit();
            return redirect()->route('pacotesCliente.detalhes', ['id' => $input['pessoa_id']])->with(['sucesso' => "Sucesso ao lançar plano ao cliente"]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('erro', 'Erro ao lançar conta' . "\n" . $e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $conta = $this->contaModel->find($id);
            foreach ($conta->parcelas as $parcela) {
                $this->parcelaModel->delete($parcela->id);
            }
            $input = $request->all();
            $input['vlr_total'] = $this->formatValueForMysql($input['vlr_total']);
            $input['vlr_restante'] = $input['vlr_total'];
            $conta = $this->contaModel->save($input);
            $this->gravaParcelas($request->get('array_parcela'), $conta->id);
            DB::commit();
            return redirect()->route('contas.' . ($request->get('tipo_operacao') == 'R' ? 'receber' : 'pagar') . '.index')
                ->with('sucesso', "Conta alterada com sucesso.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('erro', "Não foi possível salvar alterações" . "\n" . $e->getMessage());
        }
    }

    public function datatableAjax($id)
    {
        $query = $this->pessoaPacoteModal->newQuery()->where('pessoa_id', $id)->get();
        return Datatables::of($query)
            ->editColumn('nome', function ($registro) {
                return $registro->pacote->nome;
            })
            ->editColumn('dia_cobranca', function ($registro) {
                return $registro->dia_cobranca;
            })
            ->editColumn('vlr_total', function ($registro) {
                return $registro->vlr_total;
            })
            ->addColumn('action', function ($registro) {
                return '<a href="/pacotesCliente/deletar/' . $registro->id . '" title="Excluir"
                           class=
                           "btn-confirm-operation btn btn-effect-ripple btn-xs btn-danger"
                           data-original-title="Deletar"><i class="fa fa-times"></i></a>';
            })
            ->make(true);
    }


    public function deletar($id)
    {
        try {
            $this->pessoaPacoteModal->find($id)->delete();
            return redirect()->route('pessoas.listar')->with(['sucesso' => "Pacote do cliente eliminado com sucesso."]);
        } catch (\Exception $e) {
            return back()->with('erro', "Não foi possível eliminar conta" . "\n" . $e->getMessage());
        }
    }
}