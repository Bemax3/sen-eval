<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'updated_by' => \Auth::id()
        ]);
    }

    public function rules(): array
    {
        return [
            'n1_id' => ['sometimes'],
            'role_id' => ['sometimes'],
            'updated_by' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
