<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:inquiries,email',
            ],

            'phone' => ['required', 'string', 'max:20'],

            'preferred_date' => ['nullable', 'date'],

            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'An inquiry already exists for this email address.',
            'phone.required' => 'Please enter your phone number.',
            'preferred_date.date' => 'Please enter a valid preferred date.',
            'message.required' => 'Please enter your inquiry message.',
        ];
    }
}