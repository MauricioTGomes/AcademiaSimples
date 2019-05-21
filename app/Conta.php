<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model {


    protected $fillable = [
        'pessoa_id',
        'titulo',
        'data_emissao',
        'vlr_total',
        'vlr_restante',
        'qtd_parcelas',
        'observacao',
        'tipo_operacao', // P ou R
        'empresa_id',
        'qtd_dias'
    ];

    protected $table = 'contas_receber_pagar';

    public function setVlrTottalAttribute($value) {
        return $this->attributes['vlr_total'] = $this->formatValueForMysql($value);
    }

    private function formatValueForMysql($valor) {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function setVlrRestanteAttribute($value) {
        return $this->attributes['vlr_restante'] = $this->formatValueForMysql($value);
    }

    public function pagamento() {
        return $this->belongsTo(Pagamento::class, 'pagamento_id');
    }

    public function pessoa() {
        return $this->belongsTo(Pessoa::class);
    }

    public function vendedor() {
        return $this->belongsTo(Pessoa::class, 'vendedor_id');
    }

    public function parcelas() {
        return $this->hasMany(Parcela::class);
    }

    public function setDataEmissaoAttribute($value) {
        if (strlen($value) > 0) {
            try {
                $this->attributes['data_emissao'] = Carbon::createFromFormat('d/m/Y', $value);
            } catch (\Exception $e) {
                $this->attributes['data_emissao'] = date('Y-m-d');
            }
        } else {
            return null;
        }
    }

}
