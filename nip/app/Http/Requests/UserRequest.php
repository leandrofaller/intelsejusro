<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'nome' => 'required|Min:5|Max:100',
            'email' => 'required|Email|Min:3|Max:100',
            'telefone' => 'required|Min:8|Max:15',
            'matricula' => 'Integer|required',
            'password' => 'required|Min:2|Max:50',
            'password2' => 'required|Min:2|Max:50',
            'perfil' => 'required',
//            'status' => 'required',
            'unidade_id' => 'required'

        ];
    }
}
