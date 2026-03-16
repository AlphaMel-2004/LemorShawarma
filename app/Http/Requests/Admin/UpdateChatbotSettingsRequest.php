<?php

namespace App\Http\Requests\Admin;

use App\Models\SiteSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateChatbotSettingsRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $existing = SiteSetting::getChatbotSettings();
        $fallbackKeys = [
            'chatbot_name',
            'chatbot_welcome_message',
            'chatbot_fab_icon',
            'chatbot_model',
            'chatbot_knowledge',
            'chatbot_restrictions',
            'chatbot_temperature',
            'chatbot_max_tokens',
        ];

        $fallbackPayload = [];

        foreach ($fallbackKeys as $key) {
            if (! $this->has($key)) {
                $fallbackPayload[$key] = (string) ($existing[$key] ?? '');
            }
        }

        if ($fallbackPayload !== []) {
            $this->merge($fallbackPayload);
        }
    }

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
            'chatbot_enabled' => ['nullable', 'boolean'],
            'chatbot_name' => ['required', 'string', 'max:80'],
            'chatbot_welcome_message' => ['required', 'string', 'max:400'],
            'chatbot_fab_icon' => ['required', 'string', Rule::in(array_keys(SiteSetting::CHATBOT_FAB_ICON_OPTIONS))],
            'chatbot_model' => ['required', 'string', 'max:120', 'regex:/^[A-Za-z0-9._\/:-]+$/'],
            'chatbot_knowledge' => ['nullable', 'string', 'max:5000'],
            'chatbot_restrictions' => ['nullable', 'string', 'max:3000'],
            'chatbot_temperature' => ['required', 'numeric', 'between:0,1.5'],
            'chatbot_max_tokens' => ['required', 'integer', 'between:50,600'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'chatbot_name.required' => 'Please provide a chatbot display name.',
            'chatbot_welcome_message.required' => 'Please provide a welcome message.',
            'chatbot_fab_icon.required' => 'Please choose a chatbot button icon.',
            'chatbot_fab_icon.in' => 'Please choose one of the available chatbot icon options.',
            'chatbot_model.required' => 'Please provide a Hugging Face model id.',
            'chatbot_model.regex' => 'The model id contains unsupported characters.',
            'chatbot_temperature.between' => 'Temperature must be between 0 and 1.5.',
            'chatbot_max_tokens.between' => 'Max response tokens must be between 50 and 600.',
        ];
    }
}
