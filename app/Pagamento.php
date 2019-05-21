<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model {

    protected $fillable = [
        'valor_pago',
        'taxa_adicional',
        'taxa_juros',
        'estorno',
        'multa_atraso',
        'pacotes_pessoa_id',
    ];


    public function conta() {
        return $this->hasOne(Conta::class);
    }

    public function pacotesCliente() {
        return $this->hasMany(PessoaPacote::class, 'pacotes_pessoa_id');
    }

}
