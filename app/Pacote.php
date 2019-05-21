<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    protected $table = 'pacotes';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        "vlr_total",
        'observacoes',
        'categoria',
    ];

    public function setVlrTotalAttribute($value) {
        return $this->attributes['vlr_total'] = $this->formatValueForMysql($value);
    }
    function formatValueForMysql($valor) {

        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }
    public function pessoasPacote () {
        return $this->hasMany(PessoaPacote::class, 'pacote_id');
    }

}
