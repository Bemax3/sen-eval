<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class SaveGoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'goal_is_accepted' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
