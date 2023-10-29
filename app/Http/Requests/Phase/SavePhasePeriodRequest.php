<?php

namespace App\Http\Requests\Phase;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SavePhasePeriodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if(count($this->get('period')))
            $this->merge([
                'evaluation_period_start' => $this->get('period')[0],
                'evaluation_period_end' => $this->get('period')[1],
                'updated_by' => \Auth::id()
            ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phase_id' => ['required'],
            'evaluation_period_start' => ['required','date'],
            'evaluation_period_end' => ['required','after:evaluation_period_start'],
            'updated_by' => ['sometimes']
        ];
    }

    public function messages(): array
    {
        return [
            'evaluation_period_start.required' => 'Veuillez fournir une date de début.',
            'evaluation_period_end.required' => 'Veuillez fournir une date de fin.',
            'evaluation_period_end.after' => 'La date de fin doit être après la date de début.'
        ];
    }
}
