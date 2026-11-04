<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SellerProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isSeller();
    }

    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone'                => ['required', 'string', 'max:20'],
            'avatar'               => ['nullable', 'image', 'max:5120'],
            'avatar_url'           => ['nullable', 'string', 'max:500'],
            'business_name'        => ['nullable', 'string', 'max:255'],
            'business_email'       => ['nullable', 'email', 'max:255'],
            'business_phone'       => ['nullable', 'string', 'max:30'],
            'website'              => ['nullable', 'string', 'max:255'],
            'address'              => ['nullable', 'string', 'max:500'],
            'city'                 => ['nullable', 'string', 'max:100'],
            'state'                => ['nullable', 'string', 'max:100'],
            'pincode'              => ['nullable', 'string', 'max:20'],
            'business_description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

