<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacoteRequest;
use App\Pacote;
use Artesaos\SEOTools\Facades\SEOTools;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PacoteController extends Controller
{
    private $pacoteModel;

    public function __construct(Pacote $pacoteModel)
    {
        $this->middleware('auth');
        $this->pacoteModel = $pacoteModel;
    }

    public function listar()
    {
        SEOTools::setTitle('Listar pacotes');
        $pacotes = $this->pacoteModel->paginate(10);
        return view('pacote/listar', compact('pacotes'));
    }

    public function buscar($id)
    {
        $pacote = $this->pacoteModel->find($id);
        return $pacote;
    }

    public function gravar(PacoteRequest $request)
    {
        DB::beginTransaction();
        try {
            Pacote::create($request->all());
            DB::commit();
            return redirect()->route('pacote.listar')->with(['sucesso' => "Pessoa cadastrada com sucesso."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('erro', "Erro ao salvar pessoa." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pacote = $this->pacoteModel->find($id);
            $pacote->update($request->all());
            DB::commit();
            return redirect()->route('pacote.listar')->with(['sucesso' => "Pacote " . $pacote->nome . " atualizado com sucesso."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('erro', "Erro ao alterar pacote." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function datatableAjax()
    {
        $query = $this->pacoteModel->all();
        return Datatables::of($query)
            ->editColumn('nome', function ($registro) {
                return $registro->nome;
            })
            ->editColumn('observacoes', function ($registro) {
                return $registro->observacoes;
            })
            ->editColumn('vlr_total', function ($registro) {
                return $registro->vlr_total;
            })
            ->addColumn('action', function ($registro) {
                return '<a href="/pacote/deletar/' . $registro->id . '" title="Excluir"
                           class="btn-confirm-operation btn btn-effect-ripple btn-xs btn-danger"
                           data-original-title="Deletar"><i class="fa fa-times"></i></a>
                                        
                            <a href="/pacote/alterar/' . $registro->id . '" title="Alterar"
                               class="btn btn-effect-ripple btn-xs btn-success"
                               data-original-title="Alterar"><i class="fa fa-pencil"></i></a>';
            })
            ->make(true);
    }

    public function alterar($id)
    {
        SEOTools::setTitle('Alterar pacote');
        $pacote = $this->pacoteModel->find($id);
        return view('pacote/alterar', compact('pacote'));
    }

    public function deletar($id)
    {
        try {
            $pacote = $this->pacoteModel->find($id);

            if ($pacote->pessoasPacote->first() != null) {
                throw new Exception("Pacote vincúlado a um cliente");
            }

            $pacote->delete();
            return redirect()->route('pacote.listar')->with(['sucesso' => "Pacote eliminado com sucesso."]);
        } catch (\Exception $e) {
            return back()->with('erro', "Erro ao eliminar pacote." . "\n" . $e->getMessage())->withInput();
        }
    }

    public function incluir()
    {
        SEOTools::setTitle('Adicionar pacote');
        return view('pacote/adicionar');
    }

}
