<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class SaveEvaluationRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'evaluator_id' => \Auth::id()
        ]);
    }

    public function rules(): array
    {
        return [
            'phase_id' => ['required'],
            'evaluator_id' => ['required'],
            'evaluated_id' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'phase_id.required' => 'Veuillez choisir une année pour l\'evaluation.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
