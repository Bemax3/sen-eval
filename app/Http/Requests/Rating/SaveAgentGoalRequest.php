<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveAgentGoalRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'goal_name' => ['required'],
            'goal_means_available' => ['required'],
            'goal_expected_date' => ['required', 'date'],
            'goal_expected_result' => ['required'],
            'goal_marking' => ['sometimes', 'required'],
            'goal_rate' => ['sometimes', 'required', 'gte:0', 'lte:100'],
            'evaluation_period_id' => ['required'],
            'phase_id' => ['required'],
            'comment' => ['sometimes'],
            'updated_by' => ['sometimes']
        ];
    }

    public function messages(): array
    {
        return [
            'goal_name.required' => 'Veuillez renseigner le libelle de l\'objectif.',
            'goal_expected_result.required' => 'Veuillez renseigner la valeur cible de cet objectif.',
            'goal_marking.required' => 'Veuillez renseigner le barème de l\'objectif.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => \Auth::id()
        ]);
    }
}
