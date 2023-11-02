<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEvaluationSkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'evaluation_skill_mark' => [Rule::when($this->method() === $this::METHOD_POST,'sometimes'),'required','gte:0','lte:evaluation_skill_marking'],
            'evaluation_skill_marking' => [Rule::when($this->method() === $this::METHOD_POST,'sometimes'),'required','integer','gte:evaluation_skill_mark'],
            'evaluation_id' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required'],
            'phase_skill_id' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required'],
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
