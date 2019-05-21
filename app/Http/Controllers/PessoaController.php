<?php

namespace App\Http\Controllers;

use App\Http\Requests\PessoaRequest;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Pessoa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PessoaController extends BaseController
{


    private $pessoaModel;

    public function __construct(Pessoa $pessoaModel)
    {
        $this->middleware('auth');
        $this->pessoaModel = $pessoaModel;
    }

    public function listar($tipo = null)
    {
        SEOTools::setTitle('Listar pessoas');
        if ($tipo == null) $pessoas = $this->pessoaModel->paginate(10);
        return view('pessoa/listar', compact('pessoas'));
    }

    public function gravar(PessoaRequest $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $pessoa = Pessoa::create($input);

            DB::commit();
            if ($pessoa->cliente == 1) {
                return redirect()->route('pacotesCliente.incluir', ['id' => $pessoa->id])->with(['sucesso' => "Pessoa cadastrada com sucesso."]);
            } else {
                return redirect()->route('pessoas.listar')->with(['sucesso' => "Pessoa cadastrada com sucesso."]);
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('erro', "Erro ao salvar pessoa." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pessoa = $this->pessoaModel->find($id);
            $pessoa->update($request->all());
            DB::commit();
            return redirect()->route('pessoas.listar')->with(['sucesso' => "Pessoa " . ($pessoa->nome == '' ? $pessoa->fantasia : $pessoa->nome) . " alterada com sucesso."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('erro', "Erro ao eliminar pessoa." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function alterar($id)
    {
        SEOTools::setTitle('Alterar pessoa');
        $pessoa = $this->pessoaModel->find($id);
        return view('pessoa/alterar', compact('pessoa'));
    }

    public function deletar($id)
    {
        try {
            $pessoa = $this->pessoaModel->find($id);

            if (!is_null($pessoa->pacotes->first())) {
                throw new \Exception("Pessoa com planos cadastrados.");

            }

            if (!is_null($pessoa->contas->first())) {
                throw new \Exception("Pessoa com contas cadastradas.");
            }

            $pessoa->delete();
            return redirect()->route('pessoas.listar')->with(['sucesso' => "Pessoa eliminada com sucesso."]);
        } catch (\Exception $e) {
            return back()->with('erro', "Erro ao eliminar pessoa." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function incluir()
    {
        SEOTools::setTitle('Adicionar pessoa');
        return view('pessoa/adicionar');
    }

    public function datatableAjax()
    {
        $query = $this->pessoaModel->all();
        return Datatables::of($query)
            ->editColumn('nome', function ($registro) {
                return $registro->nome == '' ? $registro->fantasia : $registro->nome;
            })
            ->editColumn('cpf', function ($registro) {
                return $registro->cpf == '' ? $registro->cnpj : $registro->cpf;
            })
            ->editColumn('fone', function ($registro) {
                return $registro->fone;
            })
            ->addColumn('action', function ($registro) {
                return '    <a href="/pessoas/deletar/' . $registro->id . '" title="Excluir"
                           class="btn-confirm-operation btn btn-effect-ripple btn-xs btn-danger"
                           data-original-title="Deletar"><i class="fa fa-times"></i></a>
                           <a href="/pacotesCliente/incluir/' . $registro->id . '" title="Adicionar plano a cliente"
                           class="btn btn-effect-ripple btn-xs btn-success"
                           data-original-title="Alterar"><i class="fa fa-plus"></i></a>
                           <a href="/pessoas/alterar/' . $registro->id . '" title="Alterar"
                           class="btn btn-effect-ripple btn-xs btn-success"
                           data-original-title="Alterar"><i class="fa fa-pencil"></i></a>';
            })
            ->make(true);
    }

}
