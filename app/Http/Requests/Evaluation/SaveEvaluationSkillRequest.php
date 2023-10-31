<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEvaluationSkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'evaluation_skill_mark' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required','gt:0','lte:evaluation_skill_marking'],
            'evaluation_skill_marking' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required','integer','gt:0','gt:evaluation_skill_mark']
        ];
    }

    public function messages(): array
    {
        return [
            'evaluation_skill_mark.lte' =>  'La note ne peut pas être supérieur au barème.',
            'evaluation_skill_mark.gt' =>  'La note doit être supérieur á zero.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
