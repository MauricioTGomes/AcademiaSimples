<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PessoaPacote extends Model
{
    protected $table = 'pacotes_cliente';

    public $timestamps = false;

    protected $fillable = [
        "vlr_total",
        'vlr_desconto',
        'dia_cobranca',
        'pessoa_id',
        'pacote_id',
        'mes_faturado'
    ];

    public function setVlrTotalAttribute($value) {
        if (is_null($value)) {
            return $this->attributes['vlr_total'] = '0.00';
        }
        return $this->attributes['vlr_total'] = $this->formatValueForMysql($value);
    }

    public function setVlrDescontoAttribute($value) {
        if (is_null($value)) {
            return $this->attributes['vlr_desconto'] = '0.00';
        }
        return $this->attributes['vlr_desconto'] = $this->formatValueForMysql($value);
    }

    private function formatValueForMysql($valor) {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function pessoa() {
        return $this->hasOne(Pessoa::class, 'id', 'pessoa_id');
    }

    public function pacote() {
        return $this->hasOne(Pacote::class, 'id', 'pacote_id');
    }
}
