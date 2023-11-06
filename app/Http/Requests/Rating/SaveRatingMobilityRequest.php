<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingMobilityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'asked_by_evaluated' => ['sometimes'],
            'asked_by_evaluator' => ['sometimes'],
            'mobility_type_id' => ['required'],
            'rating_mobility_title' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
