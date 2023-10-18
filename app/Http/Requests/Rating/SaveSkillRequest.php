<?php

namespace App\Http\Requests\Rating;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveSkillRequest extends FormRequest
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
            'skill_name' => ['required','string'],
            'skill_desc' => ['required','string'],
            'skill_type_id' => ['required']

        ];
    }

    public function messages(): array
    {
        return [
            'skill_name.required' => 'Ce champ est obligatoire.',
            'skill_desc.required' => 'Ce champ est obligatoire.',
            'skill_type_id.required' => 'Ce champ est obligatoire.',
        ];
    }
}
