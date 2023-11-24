<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingSanctionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sanction_type_id' => ['required'],
            'rating_sanction_comment' => ['sometimes'],
            'updated_by' => ['sometimes']
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
