<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormHargaServisRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode_hargaservis' => 'required|unique:harga_servis,kode_hargaservis',
            'nama_hargaservis' => 'required',
            'jasa_hargaservis' => 'required',
            'profit_hargaservis' => 'required',
            'total_hargaservis' => 'required',
            'kategori_servis_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_hargaservis.required' => 'Kode wajib diisi',
            'nama_hargaservis.required' => 'Nama servis wajib diisi',
            'jasa_hargaservis.required' => 'Harga jasa wajib diisi',
            'profit_hargaservis.required' => 'Profit bengkel wajib diisi',
            'total_hargaservis.required' => 'Total harga wajib diisi',
            'kategori_servis_id.required' => 'Kategori servis wajib diisi',
            'kode_hargaservis.unique' => 'Kode servis harus unik',
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
