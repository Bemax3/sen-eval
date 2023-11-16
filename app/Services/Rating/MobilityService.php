<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Models\Rating\Mobility;
use App\Models\Rating\Rating;

class MobilityService
{
    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function create($validated, $rating_id): void
    {
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($rating_id))) throw new CantUpdateValidatedRatingException();
        $mobility = Mobility::create([
            'rating_id' => $rating_id,
            'mobility_type_id' => $validated['mobility_type_id'],
            'rating_mobility_title' => $validated['rating_mobility_title'],
            'rating_mobility_comment' => $validated['rating_mobility_comment'],
            'asked_by' => $validated['asked_by']
        ]);
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function update($validated, $mobility_id): void
    {
        $mobility = Mobility::findOrFail($mobility_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($mobility->rating_id))) throw new CantUpdateValidatedRatingException();
        $mobility->update([
            'mobility_type_id' => $validated['mobility_type_id'],
            'rating_mobility_title' => $validated['rating_mobility_title'],
            'rating_mobility_comment' => $validated['rating_mobility_comment'],
        ]);
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function delete(string $mobility_id): void
    {
        $mobility = Mobility::findOrFail($mobility_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($mobility->rating_id))) throw new CantUpdateValidatedRatingException();
        $mobility->delete();
    }
}
