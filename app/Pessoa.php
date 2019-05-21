<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoas';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'razao_social',
        'fantasia',
        'cpf',
        'rg',
        'cnpj',
        'ie',
        'fone',
        'email',
        'endereco',
        'cep',
        'endereco_nro',
        'bairro',
        'complemento',
        'sexo',
        'cliente',
        'funcionario',
        'fornecedor'
    ];

    public function pacotes() {
        return $this->hasMany(PessoaPacote::class, 'pessoa_id');
    }

    public function contas() {
        return $this->hasMany(Conta::class, 'pessoa_id');
    }
}
