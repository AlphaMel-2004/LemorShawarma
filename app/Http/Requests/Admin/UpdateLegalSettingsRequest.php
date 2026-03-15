<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLegalSettingsRequest extends FormRequest
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
            'legal_last_updated' => ['required', 'string', 'max:60'],
            'legal_privacy_intro' => ['required', 'string', 'max:255'],
            'legal_privacy_summary' => ['required', 'string', 'max:1200'],
            'legal_privacy_content' => ['required', 'string', 'max:12000'],
            'legal_terms_intro' => ['required', 'string', 'max:255'],
            'legal_terms_summary' => ['required', 'string', 'max:1200'],
            'legal_terms_content' => ['required', 'string', 'max:12000'],
            'legal_cookies_intro' => ['required', 'string', 'max:255'],
            'legal_cookies_summary' => ['required', 'string', 'max:1200'],
            'legal_cookies_content' => ['required', 'string', 'max:12000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'legal_last_updated.required' => 'Please provide the Last Updated date text.',
            'legal_privacy_content.required' => 'Privacy Policy content is required.',
            'legal_terms_content.required' => 'Terms of Service content is required.',
            'legal_cookies_content.required' => 'Cookie Policy content is required.',
        ];
    }
}
