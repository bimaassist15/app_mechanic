<?php

namespace Modules\Master\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_customer' => 'required',
            'nowa_customer' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama_customer.required' => 'Nama Customer wajib diisi',
            'nowa_customer.required' => 'Nomor Whatsapp wajib diisi',
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
