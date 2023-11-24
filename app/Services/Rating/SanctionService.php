<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\SanctionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Rating;
use App\Models\Rating\Sanction;

class SanctionService
{
    /**
     * @throws SanctionAlreadyExistException
     * @throws UnauthorizedActionException
     * @throws CantUpdateValidatedRatingException
     */
    public function create($validated, $rating_id): string
    {
        if (Sanction::where('sanction_type_id', '=', $validated['sanction_type_id'])->where('rating_id', '=', $rating_id)->exists()) throw new SanctionAlreadyExistException();
        $rating = Rating::findOrFail($rating_id);
        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        if ($rating->evaluator_id !== \Auth::id()) throw new UnauthorizedActionException();
        Sanction::create([
            'rating_id' => $rating_id,
            'sanction_type_id' => $validated['sanction_type_id'],
            'rating_sanction_comment' => $validated['rating_sanction_comment']
        ]);
        return 'ok';
    }

    /**
     * @throws SanctionAlreadyExistException
     * @throws UnauthorizedActionException
     * @throws CantUpdateValidatedRatingException
     */
    public function update($validated, $rating_sanction_id): string
    {
        $sanction = Sanction::findOrFail($rating_sanction_id);
        $rating = Rating::findOrFail($sanction->rating_id);
        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        if (Sanction::where('sanction_type_id', '=', $validated['sanction_type_id'])->where('rating_id', '=', $sanction->rating_id)->where('rating_sanction_id', '!=', $sanction->rating_sanction_id)->exists()) throw new SanctionAlreadyExistException();
        if ($rating->evaluator_id !== \Auth::id()) throw new UnauthorizedActionException();
        $sanction->update([
            'sanction_type_id' => $validated['sanction_type_id'],
            'rating_sanction_comment' => $validated['rating_sanction_comment'],
            'updated_by' => $validated['updated_by']
        ]);
        return 'ok';
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function delete(string $sanction_id): void
    {
        $sanction = Sanction::findOrFail($sanction_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($sanction->rating_id))) throw new CantUpdateValidatedRatingException();
        $sanction->delete();
    }

}
