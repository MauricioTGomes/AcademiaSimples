<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PacoteRequest extends FormRequest
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
            'nome' => 'required|min:3',
            "vlr_total" => 'required',
        ];
    }

    public function messages()
    {
        // mensagens de erro personalizadas!
        return [
            'nome.required' => 'O campo :attribute é obrigatório',
            'vlr_total.required' => 'O campo :attribute é obrigatório',
        ];
    }
}
