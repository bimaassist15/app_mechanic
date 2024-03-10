<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSPembayaranRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_spembayaran' => 'required',
            'kategori_pembayaran_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_spembayaran.required' => 'Nama Sub Pembayaran wajib diisi',
            'kategori_pembayaran_id.required' => 'Kategori pembayaran wajib diisi',
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
