<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class SaveAgentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'agent_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'agent_id.required' => 'Veuillez choisir un agent á ajouter.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
