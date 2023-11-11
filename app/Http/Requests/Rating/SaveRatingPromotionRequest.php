<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingPromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'evaluated_is_eligible' => ['sometimes'],
            'promotion_type_id' => ['required'],
            'rating_promotion_comment' => ['sometimes']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
