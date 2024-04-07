<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormBarangUpdateRequest extends FormRequest
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
            'barcode_barang' => [
                'required',
                Rule::unique('barang', 'barcode_barang')->ignore(request()->segment(3))->where(function ($query) use ($cabang_id) {
                    return $query->where('cabang_id', $cabang_id);
                }),
            ],
            'nama_barang' => 'required',
            'satuan_id' => 'required',
            'snornonsn_barang' => 'required',
            'stok_barang' => 'required',
            'hargajual_barang' => 'required',
            'lokasi_barang' => 'required',
            'kategori_id' => 'required',
            'status_barang' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'barcode_barang.required' => 'Barcode Barang wajib diisi',
            'barcode_barang.unique' => 'Barcode barang harus unik',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'satuan_id.required' => 'Satuan wajib diisi',
            'snornonsn_barang.required' => 'Serial number atau Non serial number wajib diisi',
            'stok_barang.required' => 'Stock barang wajib diisi',
            'hargajual_barang.required' => 'Harga jual barang wajib diisi',
            'lokasi_barang.required' => 'Lokasi barang wajib diisi',
            'kategori_id.required' => 'Kategori barang wajib diisi',
            'status_barang.required' => 'Status barang wajib diisi',
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
