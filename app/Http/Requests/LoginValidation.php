<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email_or_username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email_or_username.required' => 'Email atau username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];
    }
}
