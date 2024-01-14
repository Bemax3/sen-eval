<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingPromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'evaluated_is_eligible' => ['sometimes'],
            'is_proposed' => ['sometimes'],
            'promotion_type_id' => ['required'],
            'rating_promotion_comment' => ['sometimes'],
            'user_nr_prom_date' => ['sometimes'],
            'user_gf_prom_date' => ['sometimes'],
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
