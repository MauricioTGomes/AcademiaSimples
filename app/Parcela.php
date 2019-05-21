<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{

    protected $fillable = [
        'nro_parcela',
        'valor',
        'valor_pago',
        'data_vencimento',
        'data_recebimento',
        'valor_desconto',
        'baixada',
        'conta_id'
    ];

    protected $table = 'parcelas_receber_pagar';

    protected $dates = ['data_recebimento', 'data_vencimento', 'updated_at', 'created_at'];

    public function setDataVencimentoAttribute($value)
    {
        if (strlen($value) > 0) {
            try {
                $this->attributes['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $value);
            } catch (\Exception $e) {
                $this->attributes['data_vencimento'] = date('Y-m-d');
            }
        } else {
            return null;
        }
    }

    public function setDataRecebimentoAttribute($value)
    {
        if (strlen($value) > 0) {
            try {
                $this->attributes['data_recebimento'] = Carbon::createFromFormat('d/m/Y', $value);
            } catch (\Exception $e) {
                $this->attributes['data_recebimento'] = date('Y-m-d');
            }
        } else {
            return null;
        }
    }

    private function formatValueForMysql($valor)
    {
        if (strlen($valor) <= 6) {
            return str_replace(',', '.', $valor);
        }

        return str_replace(',', '.', str_replace('.', '', $valor));
    }

    public function setValorAttribute($value)
    {
        if (substr_count($value, ',') == 0) {
            return $this->attributes['valor'] = $value;
        } else {
            return $this->attributes['valor'] = $this->formatValueForMysql($value);
        }
    }

    public function setValorPagoAttribute($value)
    {
        if (substr_count($value, ',') == 0) {
            return $this->attributes['valor_pago'] = $value;
        } else {
            return $this->attributes['valor_pago'] = $this->formatValueForMysql($value);
        }
    }

    public function setValorDescontoAttribute($value)
    {
        if (substr_count($value, ',') == 0) {
            return $this->attributes['valor_desconto'] = $value;
        } else {
            return $this->attributes['valor_desconto'] = $this->formatValueForMysql($value);
        }
    }

    public function conta()
    {
        return $this->belongsTo(Conta::class, 'conta_id');
    }

}
