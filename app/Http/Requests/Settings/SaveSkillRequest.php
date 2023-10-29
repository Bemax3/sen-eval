<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSkillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => \Auth::id()
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'skill_name' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes') ,'required','string'],
            'skill_desc' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes') ,'required','string'],
            'skill_marking' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes') ,'required','integer','gt:0'],
            'skill_type_id' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes') ,'required'],
            'skill_is_active' => ['nullable'],
            'updated_by' => ['sometimes']
        ];
    }

    public function messages(): array
    {
        return [
            'skill_name.required' => 'Ce champ est obligatoire.',
            'skill_desc.required' => 'Ce champ est obligatoire.',
            'skill_type_id.required' => 'Ce champ est obligatoire.',
            'skill_marking.required' => 'Ce champ est obligatoire.',
            'skill_marking.gt' => 'Veuillez fournir un nombre supérieur à 0.',
        ];
    }
}
