<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class SaveEvaluationCommentsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'evaluator_comment' => ['sometimes','required'],
            'evaluated_comment' => ['sometimes','required']
        ];
    }

    public function messages(): array
    {
         return [
             'evaluator_comment.required' => 'Veuillez fournir un commentaire valide.',
             'evaluated_comment.required' => 'Veuillez fournir un commentaire valide.'
         ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
