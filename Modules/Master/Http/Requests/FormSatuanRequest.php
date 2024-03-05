<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSatuanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_satuan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_satuan.required' => 'Nama satuan wajib diisi',
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
