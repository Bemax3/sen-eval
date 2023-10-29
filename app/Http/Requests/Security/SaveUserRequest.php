<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'n1_id' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
