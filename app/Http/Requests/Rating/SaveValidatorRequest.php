<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveValidatorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'remember' => ['sometimes', 'nullable'],
            'validator_id' => ['sometimes', 'required'],
            'rating_validator_comment' => ['sometimes', 'required'],
            'has_validated' => ['sometimes'],
            'new_validator' => ['sometimes'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating_validator_comment.required' => 'Veuillez fournir un commentaire valide.',
            'validator_id.required' => 'Veuillez choisir votre le N + 2 de l\'agent évalué.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
