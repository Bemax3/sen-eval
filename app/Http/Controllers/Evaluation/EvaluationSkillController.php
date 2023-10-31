<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\SaveEvaluationSkillRequest;
use App\Services\Evaluation\EvaluationSkillService;
use Illuminate\Http\Request;

class EvaluationSkillController extends Controller
{

    public function __construct(private readonly EvaluationSkillService $evaluationSkillService){}

    public function update(SaveEvaluationSkillRequest $request,string $id) {
        try {
            $this->evaluationSkillService->update($request->validated(),$id);
            alert_success('Note Enregistré.');
        }catch (\Exception) {
            alert_error('Erreur lors l\'enregistrement de cette note.');
        }
    }
}
