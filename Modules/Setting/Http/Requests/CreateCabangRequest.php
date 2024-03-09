<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCabangRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bengkel_cabang' => 'required',
            'nama_cabang' => 'required',
            'nowa_cabang' => 'required',
            'kota_cabang' => 'required',
            'tipeprint_cabang' => 'required',
            'printservis_cabang' => 'required',
            'lebarprint_cabang' => 'required',
            'lebarprintservis_cabang' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'bengkel_cabang.required' => 'Bengkel cabang wajib diisi',
            'nama_cabang.required' => 'Nama cabang wajib diisi',
            'nowa_cabang.required' => 'Nomor what\'s app wajib diisi',
            'kota_cabang.required' => 'Kota cabang wajib diisi',
            'tipeprint_cabang.required' => 'Tipe print wajib diisi',
            'printservis_cabang.required' => 'Tipe print servis wajib diisi',
            'lebarprint_cabang.required' => 'Lebar ukuran print wajib diisi',
            'lebarprintservis_cabang.required' => 'Lebar ukuran print servis wajib diisi',
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
