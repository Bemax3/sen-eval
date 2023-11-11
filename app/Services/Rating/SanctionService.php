<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\SanctionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Rating;
use App\Models\Rating\Sanction;

class SanctionService
{
    /**
     * @throws SanctionAlreadyExistException
     * @throws UnauthorizedActionException
     */
    public function create($validated, $rating_id): string
    {
        if (Sanction::where('sanction_type_id', '=', $validated['sanction_type_id'])->where('rating_id', '=', $rating_id)->exists()) throw new SanctionAlreadyExistException();
        $rating = Rating::findOrFail($rating_id);
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
     */
    public function update($validated, $rating_sanction_id): string
    {
        $sanction = Sanction::findOrFail($rating_sanction_id);
        if (Sanction::where('sanction_type_id', '=', $validated['sanction_type_id'])->where('rating_id', '=', $sanction->rating_id)->where('rating_sanction_id', '!=', $sanction->rating_sanction_id)->exists()) throw new SanctionAlreadyExistException();
        $rating = Rating::findOrFail($sanction->rating_id);
        if ($rating->evaluator_id !== \Auth::id()) throw new UnauthorizedActionException();
        $sanction->update([
            'sanction_type_id' => $validated['sanction_type_id'],
            'rating_sanction_comment' => $validated['rating_sanction_comment']
        ]);
        return 'ok';
    }

    public function delete(string $sanction_id): void
    {
        Sanction::findOrFail($sanction_id)->delete();
    }

}
