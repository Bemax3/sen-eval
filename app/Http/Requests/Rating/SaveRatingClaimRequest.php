<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingClaimRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'claim_type_id' => ['required'],
            'rating_claim_comment' => ['sometimes'],
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
