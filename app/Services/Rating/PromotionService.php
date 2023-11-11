<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\PromotionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Promotion;
use App\Models\Rating\Rating;
use Auth;

class PromotionService
{
    /**
     * @throws UnauthorizedActionException
     * @throws PromotionAlreadyExistException
     */
    public function create($validated, $rating_id): void
    {
        $rating = Rating::findOrFail($rating_id);
        if ($rating->evaluator_id !== Auth::id()) throw new UnauthorizedActionException();
        if (Promotion::where('promotion_type_id', '=', $validated['promotion_type_id'])->where('rating_id', '=', $rating_id)->exists()) throw new PromotionAlreadyExistException();
        Promotion::create([
            'rating_id' => $rating_id,
            'promotion_type_id' => $validated['promotion_type_id'],
            'evaluated_is_eligible' => $validated['evaluated_is_eligible'],
            'rating_promotion_comment' => $validated['rating_promotion_comment']
        ]);
    }

    /**
     * @throws UnauthorizedActionException
     * @throws PromotionAlreadyExistException
     */
    public function update($validated, $rating_promotion_id): string
    {
        $promotion = Promotion::findOrFail($rating_promotion_id);
        $rating = Rating::findOrFail($promotion->rating_id);
        if ($rating->evaluator_id !== Auth::id()) throw new UnauthorizedActionException();
        if (Promotion::where('rating_id', '=', $promotion->rating_id)->where('rating_promotion_id', '!=', $promotion->rating_promotion_id)->where('promotion_type_id', '=', $validated['promotion_type_id'])->exists()) throw new PromotionAlreadyExistException();
        $promotion->update([
            'promotion_type_id' => $validated['promotion_type_id'],
            'evaluated_is_eligible' => $validated['evaluated_is_eligible'],
            'rating_promotion_comment' => $validated['rating_promotion_comment']
        ]);
        return 'ok';
    }

    public function delete(string $promotion_id): void
    {
        Promotion::findOrFail($promotion_id)->delete();
    }

}
