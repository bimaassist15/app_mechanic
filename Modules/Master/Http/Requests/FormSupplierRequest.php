<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSupplierRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_supplier' => 'required',
            'nowa_supplier' => 'required',
            'perusahaan_supplier' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nowa_supplier.required' => 'Nomor Whatsapp wajib diisi',
            'perusahaan_supplier.required' => 'Perusahaan supplier wajib diisi',
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
