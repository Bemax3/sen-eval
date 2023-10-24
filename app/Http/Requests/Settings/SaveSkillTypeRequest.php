<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveSkillTypeRequest extends FormRequest
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
            'skill_type_name' => ['required','string'],
            'skill_type_marking' => ['required','integer','gt:0'],
            'skill_type_desc' => ['nullable'],
        ];
    }
    public function messages(): array
    {
        return [
            'skill_type_name.required' => 'Ce champ est obligatoire.',
            'skill_type_marking.gt' => "Veuillez fournir un nombre supérieur à 0."
        ];
    }
}
