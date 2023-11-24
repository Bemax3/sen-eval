<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingMobilityRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mobility_type_id' => ['required'],
            'rating_mobility_title' => ['required'],
            'rating_mobility_comment' => ['required'],
            'asked_by' => ['required'],
            'updated_by' => ['sometimes']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'asked_by' => \Auth::id(),
            'updated_by' => \Auth::id()
        ]);
    }
}
