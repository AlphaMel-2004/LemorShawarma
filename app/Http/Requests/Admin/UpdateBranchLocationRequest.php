<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchLocationRequest extends FormRequest
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
            'branch_location_name' => ['required', 'string', 'max:255'],
            'branch_location_address' => ['required', 'string', 'max:255'],
            'branch_location_phone' => ['required', 'string', 'max:50'],
            'branch_location_hours' => ['required', 'string', 'max:255'],
            'branch_location_map_url' => ['required', 'url', 'max:2048'],
            'branch_location_image_url' => ['required', 'url', 'max:2048'],
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
            'branch_location_name.required' => 'The branch name is required.',
            'branch_location_address.required' => 'The branch address is required.',
            'branch_location_phone.required' => 'The branch phone number is required.',
            'branch_location_hours.required' => 'The branch operating hours are required.',
            'branch_location_map_url.required' => 'The directions link is required.',
            'branch_location_map_url.url' => 'Please enter a valid directions URL.',
            'branch_location_image_url.required' => 'The branch image URL is required.',
            'branch_location_image_url.url' => 'Please enter a valid image URL.',
        ];
    }
}
