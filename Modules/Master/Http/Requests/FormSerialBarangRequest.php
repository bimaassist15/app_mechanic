<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSerialBarangRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nomor_serial_barang' => 'required',
            'status_serial_barang' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nomor_serial_barang.required' => 'Nomor serial barang wajib diisi',
            'status_serial_barang.required' => 'Status serial barang wajib diisi',
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
