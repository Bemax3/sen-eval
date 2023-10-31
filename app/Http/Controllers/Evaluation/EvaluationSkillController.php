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
            switch ($this->evaluationSkillService->update($request->validated(),$id)) {
                case 'exceed': alert_error('Le total des notes pour cette section a atteint 30 points'); break;
                default: alert_success('Note Enregistré.');
            }
        }catch (\Exception) {
            alert_error('Erreur lors l\'enregistrement de cette note.');
        }
    }

    public function store(SaveEvaluationSkillRequest $request) {
        try {
            switch ($this->evaluationSkillService->create($request->validated())) {
                case 'exceed': alert_error('Le barème a atteint 30 points'); break;
                case 'exist': alert_error('Vous avez déjá ajouter cette compétence.'); break;
                default: alert_success('Compétence Ajouté.');
            }
        }catch (\Exception) {
            alert_error('Erreur lors l\'ajout de cette compétence.');
        }

    }

    public function destroy(string $id) {
        try {
            $this->evaluationSkillService->delete($id);
            alert_success('Compétence retiré avec succès.');
        }catch (\Exception) {
            alert_error('Erreur lors de la suppression de cette compétence.');

        }
    }
}
