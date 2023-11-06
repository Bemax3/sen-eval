<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingSkillRequest;
use App\Services\Rating\RatingSkillService;
use Illuminate\Http\Request;

class RatingSkillsController extends Controller
{

    public function __construct(private readonly RatingSkillService $ratingSkillService){}

    public function update(SaveRatingSkillRequest $request, string $id) {
        try {
            switch ($this->ratingSkillService->update($request->validated(),$id)) {
                case 'exceed': alert_error('Le total des notes pour cette section a atteint 30 points'); break;
                case 'revoked': alert_error('Vous ne pouvez pas vous attribuer des notes.'); break;
                default: alert_success('Note Enregistré.');
            }
        }catch (\Exception) {
            alert_error('Erreur lors l\'enregistrement de cette note.');
        }
    }

    public function store(SaveRatingSkillRequest $request) {
        try {
            switch ($this->ratingSkillService->create($request->validated())) {
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
            $this->ratingSkillService->delete($id);
            alert_success('Compétence retiré avec succès.');
        }catch (\Exception) {
            alert_error('Erreur lors de la suppression de cette compétence.');

        }
    }
}
