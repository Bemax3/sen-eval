<?php

namespace App\Http\Requests\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTrainingTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'training_type_name' => [Rule::when($this->method() === self::METHOD_PUT,'sometimes'),'required','string'],
            'training_type_is_active' => ['nullable'],
            'training_type_desc' => ['nullable']
        ];
    }
    public function messages(): array
    {
        return [
            'training_type_name.required' => 'Ce champ est obligatoire.',
        ];
    }
}
