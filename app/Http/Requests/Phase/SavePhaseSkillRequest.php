<?php

namespace App\Http\Requests\Phase;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class SavePhaseSkillRequest extends FormRequest
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
            'skill_id' => ['required'],
            'phase_skill_marking' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required','integer','gt:0'],
            'phase_skill_is_active' => ['nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'phase_skill_marking.integer' => 'Veuillez fournir un nombre entier.',
            'phase_skill_marking.gt' => 'Veuillez fournir un nombre supérieur à 0.'
        ];
    }
}
