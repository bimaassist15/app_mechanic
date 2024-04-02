<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormPendapatanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kategori_pendapatan_id' => 'required',
            'jumlah_tpendapatan' => 'required',
            'tanggal_tpendapatan' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kategori_pendapatan_id.required' => 'Kategori pendapatan wajib diisi',
            'jumlah_tpendapatan.required' => 'Jumlah pendapatan wajib diisi',
            'tanggal_tpendapatan.required' => 'Tanggal pendapatan wajib diisi',
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
