<?php

namespace App\Http\Requests\Admin;

use App\Models\SiteSetting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliverySettingsRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $existing = SiteSetting::getDeliverySettings();
        $fallback = [];

        foreach (array_keys(SiteSetting::DELIVERY_APP_META) as $app) {
            $nameKey = "delivery_{$app}_name";
            $urlKey = "delivery_{$app}_url";

            if (! $this->has($nameKey)) {
                $fallback[$nameKey] = $existing[$app]['name'];
            }

            if (! $this->has($urlKey)) {
                $fallback[$urlKey] = $existing[$app]['fallback'];
            }
        }

        if ($fallback !== []) {
            $this->merge($fallback);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [];

        foreach (array_keys(SiteSetting::DELIVERY_APP_META) as $app) {
            $rules["delivery_{$app}_enabled"] = ['nullable', 'boolean'];
            $rules["delivery_{$app}_name"] = ['required', 'string', 'max:60'];
            $rules["delivery_{$app}_url"] = ['required', 'url', 'max:255'];
        }

        return $rules;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [];

        foreach (array_keys(SiteSetting::DELIVERY_APP_META) as $app) {
            $messages["delivery_{$app}_name.required"] = 'Please provide a display name for this delivery app.';
            $messages["delivery_{$app}_url.required"] = 'Please provide a web fallback URL for this delivery app.';
            $messages["delivery_{$app}_url.url"] = 'The web fallback URL must be a valid URL.';
        }

        return $messages;
    }
}
