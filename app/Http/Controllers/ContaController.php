<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Http\Requests\ContaRequest;
use App\Parcela;
use App\Pessoa;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use League\Flysystem\Exception;
use Yajra\DataTables\Facades\DataTables;

class ContaController extends Controller
{

    private $contaModel;
    private $pessoaModel;
    private $parcelaModel;

    public function __construct(Conta $contaModel, Pessoa $pessoaModel, Parcela $parcelaModel)
    {
        $this->middleware('auth');
        $this->contaModel = $contaModel;
        $this->parcelaModel = $parcelaModel;
        $this->pessoaModel = $pessoaModel;
    }

    public function listarReceber()
    {
        SEOTools::setTitle('Listagem de conta a receber');
        $contas = $this->contaModel->newQuery()->where('tipo_operacao', 'R')->get();
        return view('conta/listar', compact('contas'));
    }

    public function listarPagar()
    {
        SEOTools::setTitle('Listagem de conta a pagar');
        $contas = $this->contaModel->newQuery()->where('tipo_operacao', 'P')->get();
        return view('conta/listar', compact('contas'));
    }

    public function getFormAdicionarReceber()
    {
        SEOTools::setTitle('Adicionar conta a receber');
        $pessoas = $this->pessoaModel->newQuery()->where('cliente', 1)->get();
        return view('conta.Receber.adicionar', compact('pessoas'));
    }

    public function getFormAdicionarPagar()
    {
        SEOTools::setTitle('Adicionar conta a pagar');
        $pessoas = $this->pessoaModel->newQuery()->where('fornecedor', 1)->get();
        return view('conta.Pagar.adicionar', compact('pessoas'));
    }

    public function calculaParcela(Request $request)
    {
        $vlrTotal = $this->formatValueForMysql($request->input('vlr_total'));
        $qtdDias = $request->input('qtd_dias');
        $qtdParcelas = $request->input('qtd_parcelas');
        $dataEmissao = Carbon::createFromFormat('d/m/Y', $request->input('data_emissao'));

        $vlr_parcela = $vlrTotal / $qtdParcelas;
        $arrayParcelas = [];
        $somaParcelas = 0;

        for ($i = 1; $i <= $qtdParcelas; $i++) {
            $dataParcela = $dataEmissao->addDays($qtdDias);
            array_push($arrayParcelas, [
                'data_vencimento' => $dataParcela->format('d/m/Y'),
                'valor' => number_format(round($vlr_parcela, 2), 2, ',', '.'),
                'nro_parcela' => $i]);
            $somaParcelas += round($vlr_parcela, 2);
        }

        $diferenca = number_format($vlrTotal - $somaParcelas, 2);

        if ($diferenca > 0) {
            $arrayParcelas[$qtdParcelas - 1]['valor'] = number_format(
                $this->formatValueForMysql($arrayParcelas[$qtdParcelas - 1]['valor']) + $diferenca, 2, ',', '.');
        }
        if ($diferenca < 0) {
            $arrayParcelas[$qtdParcelas - 1]['valor'] = number_format(
                $this->formatValueForMysql($arrayParcelas[$qtdParcelas - 1]['valor']) - ($diferenca * -1), 2, ',', '.');
        }

        return $arrayParcelas;
    }

    function formatValueForMysql($valor)
    {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function gravar(ContaRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['vlr_total'] = $this->formatValueForMysql($input['vlr_total']);
            $input['vlr_restante'] = '0.00';
            $conta = Conta::create($input);
            $this->gravaParcelas($request->get('array_parcela'), $conta->id);
            DB::commit();
            return redirect()->route('contas.' . ($request->get('tipo_operacao') == 'R' ? 'receber' : 'pagar') . '.listar' .
                '')
                ->with(['sucesso' => "Sucesso ao lançar conta", 'conta' => $conta]);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('erro', 'Erro ao lançar conta' . "\n" . $e->getMessage());
        }
    }

    private function gravaParcelas($parcelas, $contaId)
    {
        foreach ($parcelas as $index => $parcela) {
            $parcela['conta_id'] = $contaId;
            Parcela::create($parcela);
        }
    }

    public function getFormAlterarReceber($id)
    {
        try {
            $conta = $this->contaModel->find($id);
            SEOTools::setTitle('Alterar conta a receber número ' . $conta->titulo);
            $pessoas = $this->pessoaModel->newQuery()->where('cliente', 1)->get();
            foreach ($conta->parcelas as $parcela) {
                if ($parcela->baixada == 1) {
                    throw new Exception("Conta com movimentação financeira, não é possível altera-la.");
                }
            }
            return view('conta.Receber.alterar', compact('conta', 'pessoas'));
        } catch (\Exception $e) {
            return back()->with('erro', $e->getMessage());
        }
    }

    public function getFormAlterarPagar($id)
    {
        try {
            $conta = $this->contaModel->find($id);
            SEOTools::setTitle('Alterar conta a pagar número ' . $conta->titulo);
            $pessoas = $this->pessoaModel->newQuery()->where('fornecedor', 1)->get();
            foreach ($conta->parcelas as $parcela) {
                if ($parcela->baixada == 1) {
                    throw new Exception("Conta com movimentação financeira, não é possível altera-la.");
                }
            }

            return view('conta.Pagar.alterar', compact('conta', 'pessoas'));
        } catch (\Exception $e) {
            return back()->with('erro', $e->getMessage());
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
            return redirect()->route('contas.' . ($request->get('tipo_operacao') == 'R' ? 'receber' : 'pagar') . '.listar')
                ->with('sucesso', "Conta alterada com sucesso.");
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('erro', "Não foi possível salvar alterações" . "\n" . $e->getMessage());
        }
    }

    public function deletar($id)
    {
        $conta = $this->contaModel->find($id);
        $tipo = $conta->tipo_operacao == 'R' ? 'receber' : 'pagar';
        try {
            foreach ($conta->parcelas as $parcela) {
                if ($parcela->baixada == 1) {
                    throw new \Exception("Conta com movimentação financeira");

                }
            }
            $conta->delete();
            return redirect()->route('contas.' . $tipo . '.listar')->with('sucesso', "Conta eliminada com sucesso.");
        } catch (\Exception $e) {
            return back()->with('erro', "Não foi possível eliminar conta" . "\n" . $e->getMessage());
        }
    }

    function formatValueForUser($valor) {
        if (empty($valor)) {
            return '0,00';
        }
        return number_format($valor, 2, ',', '.');
    }

    public function datatableAjax()
    {
        $query = null;
        if (substr($_SERVER['REQUEST_URI'], 8, 7) == 'receber') {
            $query = $this->contaModel->newQuery()->where('tipo_operacao', 'R')->get();
        } else {
            $query = $this->contaModel->newQuery()->where('tipo_operacao', 'P')->get();
        }

        return Datatables::of($query)
            ->editColumn('titulo', function ($registro) {
                return $registro->titulo;
            })
            ->editColumn('data_emissao', function ($registro) {
                return Carbon::parse($registro->data_emissao)->format('d/m/Y');
            })
            ->editColumn('pessoa', function ($registro) {
                return $registro->pessoa->nome == '' ? $registro->pessoa->fantasia . ' - ' . $registro->pessoa->razao_social : $registro->pessoa->nome;
            })
            ->editColumn('vlr_total', function ($registro) {
                return $this->formatValueForUser($registro->vlr_total);
            })
            ->addColumn('action', function ($registro) {
                if ($registro->tipo_operacao == 'R') {
                    return '<a href="' . route('contas.deletar', ['id' => $registro->id]) . ' " title="Deletar"
                               class="btn-confirm-operation btn btn-effect-ripple btn-xs btn-danger"
                               data-original-title="Deletar"><i class="fa fa-times"></i></a>
                    
                               <a href="receber/alterar/' . $registro->id . '" title="Alterar"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-pencil"></i></a>

                               <a href="estorno/' . $registro->id . '" title="Estornar parcelas"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-undo"></i></a>

                               <a href="parcela/' . $registro->id . '" title="Ver parcelas"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-money"></i></a>';

                } else {
                    return '<a href="' . route('contas.deletar', ['id' => $registro->id]) . ' " title="Deletar"
                               class="btn-confirm-operation btn btn-effect-ripple btn-xs btn-danger"
                               data-original-title="Deletar"><i class="fa fa-times"></i></a>
                               <a href="pagar/alterar/' . $registro->id . '" title="Alterar"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-pencil"></i></a>
                                                             <a href="estorno/' . $registro->id . '" title="Estornar parcelas"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-undo"></i></a>
                               <a href="parcela/' . $registro->id . '" title="Ver parcelas"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-money"></i></a>';
                }
            })
            ->make(true);
    }
}