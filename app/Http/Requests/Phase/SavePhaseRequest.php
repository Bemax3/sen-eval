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
    protected function prepareForValidation(): void
    {
        $this->merge([
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
            'phase_name' => ['sometimes','required'],
            'phase_year' => ['sometimes','required','digits:4','integer','min:' . date('Y')],
            'period_type_id' => ['sometimes','required'],
            'phase_is_active' => ['sometimes'],
            'updated_by' => ['sometimes']
        ];
    }

    public function messages(): array
    {
        return [
            'phase_name.required' => 'Ce champ est obligatoire.',
            'phase_year.required' => 'Ce champ est obligatoire.',
            'period_type_id.required' => 'Ce champ est obligatoire.',
        ];
    }
}
