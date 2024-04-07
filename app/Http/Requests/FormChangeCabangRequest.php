<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormChangeCabangRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cabang_id = session()->get('cabang_id');
        return [
            'cabang_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cabang_id.required' => 'Cabang wajib diisi',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
