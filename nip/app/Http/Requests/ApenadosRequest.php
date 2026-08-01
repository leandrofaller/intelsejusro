<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApenadosRequest extends FormRequest
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
            'nomeapenado'=>'required',
//            'datanascimento'=>'required',
//            'nomepai'=>'required', 'nomemae'=>'required', 'sexo'=>'required',
//            'etnia'=>'required',
//
//            'numeroprocesso'=>'required', 'artigos'=>'required',  'monitorado'=>'required',
//
//            'regime'=>'required', 'dataentrada'=>'required', 'oficioentrada'=>'required',
//            'presooriundo'=>'required', 'situacao'=>'required',
        ];
    }
}
