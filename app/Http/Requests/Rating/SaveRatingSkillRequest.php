<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRatingSkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating_skill_mark' => [Rule::when($this->method() === $this::METHOD_POST,'sometimes'),'required','gte:0','lte:rating_skill_marking'],
            'rating_skill_marking' => [Rule::when($this->method() === $this::METHOD_POST,'sometimes'),'required','integer'],
            'rating_id' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required'],
            'phase_skill_id' => [Rule::when($this->method() === $this::METHOD_PUT,'sometimes'),'required'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating_skill_mark.lte' =>  'La note ne peut pas être supérieur au barème.',
            'rating_skill_mark.gt' =>  'La note doit être supérieur á zero.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
