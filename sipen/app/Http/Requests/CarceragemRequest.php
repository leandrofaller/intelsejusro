<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarceragemRequest extends FormRequest
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
            'nomecarceragem' => 'required',
            'tipocarceragem' => 'required',
        ];
    }
}
