<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormKendaraanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'nopol_kendaraan' => 'required',
            'norangka_kendaraan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Customer wajib diisi',
            'nopol_kendaraan.required' => 'Nomor polisi wajib diisi',
            'norangka_kendaraan.required' => 'No. Rangka kendaraan wajib diisi',
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
