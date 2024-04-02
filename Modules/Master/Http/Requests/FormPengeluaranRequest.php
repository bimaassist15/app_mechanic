<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormPengeluaranRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kategori_pengeluaran_id' => 'required',
            'jumlah_tpengeluaran' => 'required',
            'tanggal_tpengeluaran' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kategori_pengeluaran_id.required' => 'Kategori pengeluaran wajib diisi',
            'jumlah_tpengeluaran.required' => 'Jumlah pengeluaran wajib diisi',
            'tanggal_tpengeluaran.required' => 'Tanggal pengeluaran wajib diisi',
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
