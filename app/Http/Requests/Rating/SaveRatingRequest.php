<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'phase_id' => ['sometimes', 'required'],
            'evaluated_id' => ['sometimes', 'required'],
            'evaluator_id' => ['sometimes', 'required'],
            'rating_is_contested' => ['sometimes', 'required'],
        ];
    }

    public function messages(): array
    {
        return [
            'phase_id.required' => 'Veuillez choisir l\'année pour laquelle l\'agent est évalué.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['evaluator_id' => \Auth::id()]);
    }
}
