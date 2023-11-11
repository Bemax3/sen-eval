<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingTrainingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'asked_by_evaluated' => ['sometimes'],
            'asked_by_evaluator' => ['sometimes'],
            'training_type_id' => ['sometimes'],
            'comment' => ['sometimes']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
