<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9\+\-\.\s\(\)]{8,20}$/'],
            'email' => ['nullable', 'email', 'max:160'],
            'need' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:2000'],
            // Honeypot chống spam: phải để trống.
            'website' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'email.email' => 'Email không hợp lệ.',
            'website.max' => 'Phát hiện spam.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'họ và tên',
            'phone' => 'số điện thoại',
            'message' => 'lời nhắn',
        ];
    }
}
