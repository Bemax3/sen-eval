<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveGoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'goal_is_accepted' => ['sometimes','required'],
            'goal_comment' => ['sometimes'],
            'goal_mark' => ['sometimes','required','lte:goal_marking','gte:0'],
            'goal_marking' => ['sometimes','required'],
            'rating_id' => ['sometimes','required']
        ];
    }

    public function messages(): array
    {
        return [
            'goal_mark.lte' =>  'La note ne peut pas être supérieur au barème.',
            'goal_mark.gt' =>  'La note doit être supérieur á zero.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
