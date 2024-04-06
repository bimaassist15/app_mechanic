<?php

namespace Modules\Transaction\Http\Requests;

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
            'jatuhtempo_pembelian' => 'required',
            'keteranganjtempo_pembelian' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jatuhtempo_pembelian.required' => 'Tanggal Jatuh tempo wajib diisi',
            'keteranganjtempo_pembelian.required' => 'Keterangan Jatuh tempo wajib diisi',
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
