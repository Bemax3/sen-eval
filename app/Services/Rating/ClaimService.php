<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\ClaimAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Claim;
use App\Models\Rating\Rating;
use Auth;

class ClaimService
{
    /**
     * @throws UnauthorizedActionException
     * @throws ClaimAlreadyExistException
     * @throws CantUpdateValidatedRatingException
     */
    public function create($validated, $rating_id): void
    {
        $rating = Rating::findOrFail($rating_id);
        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        $claim = Claim::where('claim_type_id', '=', $validated['claim_type_id'])->where('rating_id', '=', $rating_id)->first();
        if ($rating->evaluated_id !== Auth::id()) throw new UnauthorizedActionException();
        if ($claim) throw new ClaimAlreadyExistException();
        Claim::create([
            'rating_id' => $rating_id,
            'claim_type_id' => $validated['claim_type_id'],
            'rating_claim_comment' => $validated['rating_claim_comment']
        ]);
    }

    /**
     * @throws ClaimAlreadyExistException
     * @throws UnauthorizedActionException
     * @throws CantUpdateValidatedRatingException
     */
    public function update(mixed $validated, string $rating_claim_id): void
    {
        $claim = Claim::findOrFail($rating_claim_id);
        $rating = Rating::findOrFail($claim->rating_id);
        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        if (Claim::where('claim_type_id', '=', $validated['claim_type_id'])->where('rating_id', '=', $claim->rating_id)->where('rating_claim_id', '!=', $claim->rating_claim_id)->exists()) throw new ClaimAlreadyExistException();
        if ($rating->evaluated_id !== Auth::id()) throw new UnauthorizedActionException();
        $claim->update([
            'claim_type_id' => $validated['claim_type_id'],
            'rating_claim_comment' => $validated['rating_claim_comment']
        ]);
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function delete(string $claim_id): void
    {
        $claim = Claim::findOrFail($claim_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($claim->rating_id))) throw new CantUpdateValidatedRatingException();
        $claim->delete();
    }

}
