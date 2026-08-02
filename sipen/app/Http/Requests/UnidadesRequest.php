<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnidadesRequest extends FormRequest
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
            'nomeunidade' => 'required',
            'cidadeunidade' => 'required',
            'cnpj' => 'required',
            'endereco' => 'required',
            'siglaunidade' => 'required',
            'tipoestabelecimento' => 'required',
            'nomediretorgeral' => 'required',
            'nomediretoradm' => 'required',
            'nomediretorseg' => 'required',
            'telefoneunidade' => 'required',
            'categoria' => 'required',
            'capacidade' => 'required'

        ];
    }
}
