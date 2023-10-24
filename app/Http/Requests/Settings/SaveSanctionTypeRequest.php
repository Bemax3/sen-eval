<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSanctionTypeRequest extends FormRequest
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
            'sanction_type_name' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes'),'required','string'],
            'sanction_type_is_active' => ['nullable'],
            'sanction_type_desc' => ['nullable']
        ];
    }
    public function messages(): array
    {
        return [
            'sanction_type_name.required' => 'Ce champ est obligatoire.',
        ];
    }
}
