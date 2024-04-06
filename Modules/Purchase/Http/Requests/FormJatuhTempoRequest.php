<?php

namespace Modules\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormJatuhTempoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jatuhtempo_penjualan' => 'required',
            'keteranganjtempo_penjualan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jatuhtempo_penjualan.required' => 'Tanggal Jatuh tempo wajib diisi',
            'keteranganjtempo_penjualan.required' => 'Keterangan Jatuh tempo wajib diisi',
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
