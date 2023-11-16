<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\DefaultSkillNeedsANameException;
use App\Exceptions\Rating\SkillAlreadyExistException;
use App\Exceptions\Rating\SkillsExceedsMarkingException;
use App\Exceptions\UnauthorizedActionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingSkillRequest;
use App\Services\Rating\RatingSkillService;

class RatingSkillsController extends Controller
{

    public function __construct(private readonly RatingSkillService $ratingSkillService)
    {
    }

    public function update(SaveRatingSkillRequest $request, string $id)
    {
        try {
            $this->ratingSkillService->update($request->validated(), $id);
            alert_success('Note Enregistré.');
        } catch (UnauthorizedActionException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        }
    }

    public function store(SaveRatingSkillRequest $request)
    {
        try {
            $this->ratingSkillService->create($request->validated());
            alert_success('Compétence Ajouté.');
        } catch (SkillsExceedsMarkingException|SkillAlreadyExistException|DefaultSkillNeedsANameException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        }

    }

    public function destroy(string $id)
    {
        try {
            $this->ratingSkillService->delete($id);
            alert_success('Compétence retiré avec succès.');
        } catch (CantUpdateValidatedRatingException|ModelNotFoundException $e) {
            alert_error($e->getMessage());
        }
    }
}
