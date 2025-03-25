<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    $domain = substr(strrchr($value, "@"), 1);
                    if (!checkdnsrr($domain, 'MX')) {
                        $fail('Tên miền email không hợp lệ hoặc không tồn tại.');
                    }
                }
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'terms' => 'accepted',
        ];
    }

    protected function prepareForValidation()
    {
         /** @var \Illuminate\Http\Request $this */
        $this->merge([
            'email' => strtolower($this->input('email'))
        ]);
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Vui lòng nhập tên.',
            'last_name.required' => 'Vui lòng nhập họ.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản.',
        ];
    }
}
