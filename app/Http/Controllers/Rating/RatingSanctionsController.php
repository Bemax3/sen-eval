<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\SanctionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingSanctionRequest;
use App\Models\Rating\Rating;
use App\Models\Settings\SanctionType;
use App\Models\User;
use App\Services\Rating\SanctionService;
use Inertia\Inertia;

class RatingSanctionsController extends Controller
{

    public function __construct(private readonly SanctionService $sanctionService)
    {
    }

    public function index(string $rating_id)
    {
        try {
            $rating = Rating::with('phase', 'evaluator', 'evaluated')->findOrFail($rating_id);
            return Inertia::render('Rating/RatingSanctions', [
                'agent' => User::with('org')->findOrFail($rating->evaluated_id),
                'rating' => $rating,
                'types' => SanctionType::where('sanction_type_is_active', '=', 1)->get(),
                'sanctions' => $rating->sanctions()->with('type')->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }


    public function store(SaveRatingSanctionRequest $request, string $rating_id)
    {
        try {
            $this->sanctionService->create($request->validated(), $rating_id);
            alert_success('Sanction enregistré avec succès.');
        } catch (UnauthorizedActionException|SanctionAlreadyExistException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingSanctionRequest $request, string $rating_id, string $rating_claim_id)
    {
        try {
            $this->sanctionService->update($request->validated(), $rating_claim_id);
            alert_success('Sanction enregistré avec succès.');
        } catch (ModelNotFoundException|UnauthorizedActionException|SanctionAlreadyExistException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }


    public function destroy(string $rating_id, string $sanction_id)
    {
        try {
            $this->sanctionService->delete($sanction_id);
            alert_success('Vous avez annuler la sanction.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
