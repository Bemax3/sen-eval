<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingMobilityRequest;
use App\Models\Rating\Rating;
use App\Models\Settings\MobilityType;
use App\Models\User;
use App\Services\Rating\MobilityService;
use Inertia\Inertia;

class RatingMobilitiesController extends Controller
{
    public function __construct(private readonly MobilityService $mobilityService)
    {
    }

    public function index(string $rating_id)
    {
        try {
            $rating = Rating::with('phase', 'evaluator', 'evaluated',)->findOrFail($rating_id);
            return Inertia::render('Rating/RatingMobilities', [
                'agent' => User::with('org')->findOrFail($rating->evaluated_id),
                'rating' => $rating,
                'types' => MobilityType::where('mobility_type_is_active', '=', 1)->get(),
                'mobilities' => $rating->mobilities()->with('type')->with('asked_by')->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }


    public function store(SaveRatingMobilityRequest $request, string $rating_id)
    {
        try {
            $this->mobilityService->create($request->validated(), $rating_id);
            alert_success('Demande de mobilité enregistré avec succès.');
        } catch (CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingMobilityRequest $request, string $rating_id, string $mobility_id)
    {
        try {
            $this->mobilityService->update($request->validated(), $mobility_id);
            alert_success('Demande de mobilité modifié.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id, string $mobility_id)
    {
        try {
            $this->mobilityService->delete($mobility_id);
            alert_success('Vous avez annuler votre demande pour cette mobilité.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
