<?php

namespace App\Http\Controllers;

use App\Parcela;
use App\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    private $parcelaModel;

    public function __construct(Parcela $parcelaModel)
    {
        $this->middleware('auth');
        $this->parcelaModel = $parcelaModel;
    }

    public function register () {
        SEOTools::setTitle('Cadastrar usuário');
        return view('auth/register');
    }

    protected function create(Request $data){
        $data = $data->all();
        try {
            DB::beginTransaction();
            User::create([
                'name' => $data['nome'],
                'email' => $data['email'],
                'password' => bcrypt($data['senha']),
            ]);
            DB::commit();
            return redirect()->route('index')->with(['sucesso' => "Usuário cadastrada com sucesso."]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('erro', "Erro ao salvar usuário." . "\n" . $e->getMessage())->withInput();
        }
    }

    function formatValueForUser($valor) {
        if (empty($valor)) {
            return '0,00';
        }
        return number_format($valor, 2, ',', '.');
    }

    public function index()
    {
        $parcelas = $this->parcelaModel->all();
        $totais = [
            'receberAtrasado' => 0,
            'recebidoDia' => 0,
            'pagarDia' => 0,
            'pagarGeral' => 0,
            'receberGeral' => 0,
            'caixa' => 0,
            'recebido' => 0,
            'pago' => 0,
            'receberDia' => 0
        ];

        foreach ($parcelas as $parcela) {
            if ($parcela->conta->tipo_operacao == 'R') {
                if ($parcela->baixada == 0) {
                    $totais['receberGeral'] += $parcela->valor;
                }

                if ($parcela->baixada == 0 && $parcela->data_vencimento->format('Y-m-d') < Carbon::now()->format('Y-m-d')) {
                    $totais['receberAtrasado'] += $parcela->valor;
                }

                if ($parcela->baixada == 1 && $parcela->data_recebimento->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $totais['recebidoDia'] += $parcela->valor_pago;
                }

                if ($parcela->baixada == 0 && $parcela->data_vencimento->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $totais['receberDia'] += $parcela->valor_pago;
                }

                if ($parcela->baixada == 1) {
                    $totais['recebido'] += $parcela->valor_pago;
                }
            }

            if ($parcela->conta->tipo_operacao == 'P') {
                $totais['pagarGeral'] += $parcela->valor;

                if ($parcela->baixada == 0 && $parcela->data_vencimento->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $totais['pagarDia'] += $parcela->valor;
                }

                if ($parcela->baixada == 1) {
                    $totais['pago'] += $parcela->valor;
                }
            }
        }

        $totais['caixa'] = $totais['recebido'] - $totais['pago'];
        $totais['receberAtrasado'] = $this->formatValueForUser($totais['receberAtrasado']);
        $totais['recebidoDia'] = $this->formatValueForUser($totais['recebidoDia']);
        $totais['pagarDia'] = $this->formatValueForUser($totais['pagarDia']);
        $totais['pagarGeral'] = $this->formatValueForUser($totais['pagarGeral']);
        $totais['receberGeral'] = $this->formatValueForUser($totais['receberGeral']);
        $totais['caixa'] = $this->formatValueForUser($totais['caixa']);
        $totais['recebido'] = $this->formatValueForUser($totais['recebido']);
        $totais['pago'] = $this->formatValueForUser($totais['pago']);
        $totais['receberDia'] = $this->formatValueForUser($totais['receberDia']);

        return view('welcome')->with($totais);
    }

}