<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveGoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'goal_is_accepted' => ['sometimes', 'required'],
            'comment' => ['sometimes', 'required'],
            'goal_mark' => ['sometimes', 'required', 'lte:goal_marking', 'gt:0'],
            'goal_marking' => ['sometimes', 'required'],
            'rating_id' => ['sometimes', 'required']
        ];
    }

    public function messages(): array
    {
        return [
            'goal_mark.lte' => 'La note ne peut pas être supérieur au barème.',
            'goal_mark.gt' => 'La note doit être supérieur á zero.',
            'comment.required' => 'Veuillez fournir un commentaire valide.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
