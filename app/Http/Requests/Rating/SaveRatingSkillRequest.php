<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingSkillRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating_skill_mark' => ['sometimes', 'required', 'gt:0', 'lte:rating_skill_marking'],
            'rating_skill_marking' => ['sometimes', 'required', 'integer'],
            'rating_id' => ['sometimes', 'required'],
            'phase_skill_id' => ['sometimes', 'required'],
            'rating_skill_name' => ['sometimes', 'nullable']
        ];
    }

    public function messages(): array
    {
        return [
            'rating_skill_mark.lte' => 'La note ne peut pas être supérieur au barème.',
            'rating_skill_mark.gt' => 'La note doit être supérieur á zero.',
            'rating_skill_name' => 'Veuillez renseigner la compétence spécifique à évaluer.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
