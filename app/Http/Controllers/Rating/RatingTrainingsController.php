<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingTrainingRequest;
use App\Models\Rating\Rating;
use App\Models\Settings\TrainingType;
use App\Models\User;
use App\Services\Rating\TrainingService;
use Inertia\Inertia;

class RatingTrainingsController extends Controller
{

    public function __construct(private readonly TrainingService $trainingService)
    {
    }

    public function index(string $rating_id)
    {
        $rating = Rating::with('phase', 'evaluator', 'evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingTrainings', [
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => TrainingType::where('training_type_is_active', '=', 1)->get(),
            'trainings' => $rating->trainings()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingTrainingRequest $request, string $rating_id)
    {
        try {
            $this->trainingService->create($request->validated(), $rating_id);
            alert_success('Demande de formation enregistré avec succès.');
        } catch (CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(SaveRatingTrainingRequest $request, string $rating_id, string $training_id)
    {
        try {
            $this->trainingService->update($request->validated(), $training_id);
            alert_success('Vous avez annuler votre demande pour cette formation.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingTrainingRequest $request, string $rating_id, string $training_id)
    {
        try {
            $this->trainingService->update($request->validated(), $training_id);
            alert_success('Demande de formation enregistré avec succès.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
