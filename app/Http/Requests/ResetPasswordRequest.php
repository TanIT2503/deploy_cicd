<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'hash_reset'    => 'required|exists:admins,hash_reset',
            'password'      => 'required|min:6|max:30',
            're_password'   => 'required|same:password',
        ];
    }
}
