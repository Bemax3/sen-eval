<?php

namespace App\Http\Requests\Phase;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SavePhaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if(count($this->get('phase1')) && count($this->get('phase2'))) {
            $this->merge([
                'phase_first_eval_start' => $this->get('phase1')[0],
                'phase_first_eval_end' => $this->get('phase1')[1],
                'phase_second_eval_start' => $this->get('phase2')[0],
                'phase_second_eval_end' => $this->get('phase2')[1],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phase_name' => ['required'],
            'phase1' => ['required','array'],
            'phase2' => ['required','array'],
            'phase_first_eval_start' => ['required','date'],
            'phase_first_eval_end' => ['required','date','after:phase_first_eval_start'],
            'phase_second_eval_start' => ['required','date'],
            'phase_second_eval_end' => ['required','date','after:phase_second_eval_start']
        ];
    }

    public function messages(): array
    {
        return [
            'phase_name.required' => 'Ce champ est obligatoire.',
            'phase_first_eval_start.required' => 'Veuillez fournir une date de début.',
            'phase_second_eval_start.required' => 'Veuillez fournir une date de début.',
            'phase_first_eval_end.required' => 'Veuillez fournir une date de fin.',
            'phase_second_eval_end.required' => 'Veuillez fournir une date de fin.',
            'phase_first_eval_end.after' => 'La date de fin doit être aprés la date de début.',
            'phase_second_eval_end.after' => 'La date de fin doit être aprés la date de début.',
        ];
    }
}
