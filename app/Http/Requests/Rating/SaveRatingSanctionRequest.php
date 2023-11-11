<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class SaveRatingSanctionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sanction_type_id' => ['required'],
            'rating_sanction_comment' => ['sometimes']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
