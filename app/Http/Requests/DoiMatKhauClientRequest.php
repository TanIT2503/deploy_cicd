<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoiMatKhauClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'         => 'required|exists:khach_hangs,email',
            'password'      => 'required|min:3',
            're_password'   => 'same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.*'         => 'Email không tồn tại!',
            'password.*'      => 'Mật khẩu từ 3 ký tự trở lên!',
            're_password.*'   => 'Nhập lại mật không khớp!',
        ];
    }
}
