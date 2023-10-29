<?php

namespace App\Http\Requests\Utilities;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => ['string', 'required'],
            'fields' => ['array', 'required'],
            'phase_id' => ['sometimes','nullable'],
            'org_id' => ['sometimes','nullable']
        ];
    }
}
