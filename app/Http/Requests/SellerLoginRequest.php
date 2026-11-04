<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login'    => ['nullable', 'string'],
            'email'    => ['nullable', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $identifier = $this->input('login') ?? $this->input('email');
            if (empty(trim((string)$identifier))) {
                $validator->errors()->add('login', 'Please enter your registered Email Address or Seller ID.');
                $validator->errors()->add('email', 'Please enter your registered Email Address or Seller ID.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'login.required'    => 'Please enter your registered Email Address or Seller ID.',
            'email.required'    => 'Please enter your registered Email Address or Seller ID.',
            'password.required' => 'Please enter your password.',
        ];
    }
}
