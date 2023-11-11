<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'evaluator_comment' => ['sometimes', 'required'],
            'evaluated_comment' => ['sometimes', 'required'],
            'validator_id' => ['sometimes', 'required'],
            'remember' => ['sometimes', 'nullable'],
            'phase_id' => ['sometimes', 'required'],
            'evaluated_id' => ['sometimes', 'required'],
            'evaluator_id' => ['sometimes', 'required'],
            'validated_by_n2' => ['sometimes', 'required'],
            'validated_by_n1' => ['sometimes', 'required'],
            'rating_is_contested' => ['sometimes', 'required']
        ];
    }

    public function messages(): array
    {
        return [
            'evaluator_comment.required' => 'Veuillez fournir un commentaire valide.',
            'evaluated_comment.required' => 'Veuillez fournir un commentaire valide.',
            'validator_id.required' => 'Veuillez choisir votre le N + 2 de l\'agent évalué.',
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
