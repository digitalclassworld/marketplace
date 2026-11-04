<?php

namespace App\Http\Requests;

use App\Models\Seller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellerRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $type = strtolower(trim((string)$this->input('account_type')));
        if (str_contains($type, 'individual') || str_contains($type, 'freelancer')) {
            $this->merge(['account_type' => Seller::ACCOUNT_TYPE_INDIVIDUAL]);
        } elseif (str_contains($type, 'institute') || str_contains($type, 'company')) {
            $this->merge(['account_type' => Seller::ACCOUNT_TYPE_INSTITUTE]);
        } elseif (str_contains($type, 'agency')) {
            $this->merge(['account_type' => Seller::ACCOUNT_TYPE_AGENCY]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validAccountTypes = [
            Seller::ACCOUNT_TYPE_INDIVIDUAL,
            Seller::ACCOUNT_TYPE_INSTITUTE,
            Seller::ACCOUNT_TYPE_AGENCY,
        ];

        return [
            // Step 1: Personal Details
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'                 => ['required', 'string', 'max:20'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string'],

            // Step 2: Account Type & Business Details
            'account_type'          => ['required', 'string', Rule::in($validAccountTypes)],
            'business_name'         => ['nullable', 'string', 'max:255'],
            'business_email'        => ['nullable', 'email', 'max:255'],
            'business_phone'        => ['nullable', 'string', 'max:30'],
            'business_category'     => ['nullable', 'string', 'max:100'],
            'business_description'  => ['nullable', 'string', 'max:1000'],
            'website'               => ['nullable', 'string', 'max:255'],
            'address'               => ['nullable', 'string', 'max:500'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'state'                 => ['nullable', 'string', 'max:100'],
            'pincode'               => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required'         => 'Please enter your full name.',
            'email.required'        => 'Email address is required.',
            'email.unique'          => 'This email address is already registered. Please login instead.',
            'phone.required'        => 'Mobile number is required.',
            'password.required'     => 'Please choose a secure password.',
            'password.min'          => 'Password must be at least 6 characters.',
            'password.confirmed'    => 'Password confirmation does not match.',
            'account_type.required' => 'Please select your seller account type.',
            'account_type.in'       => 'Please select a valid account type.',
        ];
    }
}
