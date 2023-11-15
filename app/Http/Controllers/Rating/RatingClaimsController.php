<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\ClaimAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingClaimRequest;
use App\Models\Rating\Rating;
use App\Models\Settings\ClaimType;
use App\Models\User;
use App\Services\Rating\ClaimService;
use Inertia\Inertia;

class RatingClaimsController extends Controller
{
    public function __construct(private readonly ClaimService $claimService)
    {
    }

    public function index(string $rating_id)
    {
        try {
            $rating = Rating::with('phase', 'evaluator', 'evaluated')->findOrFail($rating_id);
            return Inertia::render('Rating/RatingClaims', [
                'agent' => User::with('org')->findOrFail($rating->evaluated_id),
                'rating' => $rating,
                'types' => ClaimType::where('claim_type_is_active', '=', 1)->get(),
                'claims' => $rating->claims()->with('type')->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }


    public function store(SaveRatingClaimRequest $request, string $rating_id)
    {
        try {
            $this->claimService->create($request->validated(), $rating_id);
            alert_success('Réclamation enregistré avec succès.');
        } catch (UnauthorizedActionException|ClaimAlreadyExistException|UnknownException $e) {
            alert_error($e);
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingClaimRequest $request, string $rating_id, string $rating_claim_id)
    {
        try {
            $this->claimService->update($request->validated(), $rating_claim_id);
            alert_success('Réclamation enregistré avec succès.');
        } catch (ModelNotFoundException|UnauthorizedActionException|ClaimAlreadyExistException|UnknownException $e) {
            alert_error($e);
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id, string $claim_id)
    {
        try {
            $this->claimService->delete($claim_id);
            alert_success('Vous avez annuler la réclamation.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
