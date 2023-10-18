<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveClaimTypeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'claim_type_name' => ['required', 'string'],
            'claim_type_desc' => ['nullable']
        ];
    }
    public function messages(): array
    {
        return [
            'claim_type_name.required' => 'Ce champ est obligatoire.',
        ];
    }
}
