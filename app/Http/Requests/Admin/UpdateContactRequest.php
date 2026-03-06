<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_address_line1' => ['required', 'string', 'max:255'],
            'contact_address_line2' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_hours' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'contact_address_line1.required' => 'The address is required.',
            'contact_phone.required' => 'The phone number is required.',
            'contact_email.required' => 'The email address is required.',
            'contact_email.email' => 'Please enter a valid email address.',
            'contact_hours.required' => 'The operating hours are required.',
        ];
    }
}
