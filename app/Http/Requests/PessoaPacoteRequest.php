<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PessoaPacoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'vlr_total' => 'required',
            'dia_cobranca' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vlr_total.required' => 'O campo :attribute é obrigatório',
            'dia_cobranca.required' => 'O campo :attribute é obrigatório',
        ];
    }
}
