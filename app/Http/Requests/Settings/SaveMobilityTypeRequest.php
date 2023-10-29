<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveMobilityTypeRequest extends FormRequest
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
            'mobility_type_name' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes'),'required','string'],
            'mobility_type_is_active' => ['nullable'],
            'mobility_type_desc' => ['nullable'],
            'updated_by' => ['sometimes']
        ];
    }
    public function messages(): array
    {
        return [
            'mobility_type_name.required' => 'Ce champ est obligatoire.',
        ];
    }
}
