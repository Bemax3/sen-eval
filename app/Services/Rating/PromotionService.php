<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\AgentIsNotEligibleForAdvancementException;
use App\Exceptions\Rating\AgentIsNotEligibleForPromotionException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\PromotionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Promotion;
use App\Models\Rating\Rating;
use App\Models\Settings\PromotionType;
use Auth;
use Carbon\Carbon;

class PromotionService
{
    /**
     * @throws UnauthorizedActionException
     * @throws PromotionAlreadyExistException
     * @throws CantUpdateValidatedRatingException
     * @throws AgentIsNotEligibleForPromotionException
     * @throws AgentIsNotEligibleForAdvancementException
     */
    public function create($validated, $rating_id): void
    {
        $rating = Rating::findOrFail($rating_id);


        if ($validated['promotion_type_id'] == PromotionType::PROMOTION) {
            $gf_date = Carbon::createFromDate($validated['user_gf_prom_date'])->startOfDay();
            $gf_year = Carbon::createFromDate($validated['user_gf_prom_date'])->startOfYear();
            $gf_date->isAfter($gf_year) ? $gf_date->addYears(4)->startOfYear() : $gf_date->addYears(3)->startOfYear();

            if ($validated['evaluated_is_eligible'] && $gf_date->isAfter(Carbon::today()->startOfDay())) throw new AgentIsNotEligibleForPromotionException();
        }

        if ($validated['promotion_type_id'] == PromotionType::ADVANCEMENT) {
            $nr_date = Carbon::createFromDate($validated['user_nr_prom_date'])->startOfDay();
            $nr_year = Carbon::createFromDate($validated['user_nr_prom_date'])->startOfYear();
            $nr_date->isAfter($nr_year) ? $nr_date->addYears(3)->startOfYear() : $nr_date->addYears(2)->startOfYear();

            if ($validated['evaluated_is_eligible'] && $nr_date->isAfter(Carbon::today()->startOfDay())) throw new AgentIsNotEligibleForAdvancementException();
        }

        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        if ($rating->evaluator_id !== Auth::id()) throw new UnauthorizedActionException();
        if (Promotion::where('promotion_type_id', '=', $validated['promotion_type_id'])->where('rating_id', '=', $rating_id)->exists()) throw new PromotionAlreadyExistException();

        Promotion::create([
            'rating_id' => $rating_id,
            'promotion_type_id' => $validated['promotion_type_id'],
            'evaluated_is_eligible' => $validated['evaluated_is_eligible'],
            'is_proposed' => $validated['is_proposed'],
            'rating_promotion_comment' => $validated['rating_promotion_comment']
        ]);
    }

    /**
     * @throws UnauthorizedActionException
     * @throws PromotionAlreadyExistException
     * @throws CantUpdateValidatedRatingException
     * @throws AgentIsNotEligibleForPromotionException
     * @throws AgentIsNotEligibleForAdvancementException
     */
    public function update($validated, $rating_promotion_id): void
    {
        $promotion = Promotion::findOrFail($rating_promotion_id);
        $rating = Rating::findOrFail($promotion->rating_id);

        if ($validated['promotion_type_id'] == PromotionType::PROMOTION) {
            $gf_date = Carbon::createFromDate($validated['user_gf_prom_date'])->startOfDay();
            $gf_year = Carbon::createFromDate($validated['user_gf_prom_date'])->startOfYear();
            $gf_date->isAfter($gf_year) ? $gf_date->addYears(4)->startOfYear() : $gf_date->addYears(3)->startOfYear();

            if ($validated['evaluated_is_eligible'] && $gf_date->isAfter(Carbon::today()->startOfDay())) throw new AgentIsNotEligibleForPromotionException();
        }

        if ($validated['promotion_type_id'] == PromotionType::ADVANCEMENT) {
            $nr_date = Carbon::createFromDate($validated['user_nr_prom_date'])->startOfDay();
            $nr_year = Carbon::createFromDate($validated['user_nr_prom_date'])->startOfYear();
            $nr_date->isAfter($nr_year) ? $nr_date->addYears(3)->startOfYear() : $nr_date->addYears(2)->startOfYear();

            if ($validated['evaluated_is_eligible'] && $nr_date->isAfter(Carbon::today()->startOfDay())) throw new AgentIsNotEligibleForAdvancementException();
        }


        if ((new ValidatorService())->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();
        if ($rating->evaluator_id !== Auth::id()) throw new UnauthorizedActionException();
        if (Promotion::where('rating_id', '=', $promotion->rating_id)->where('rating_promotion_id', '!=', $promotion->rating_promotion_id)->where('promotion_type_id', '=', $validated['promotion_type_id'])->exists()) throw new PromotionAlreadyExistException();
        $promotion->update([
            'promotion_type_id' => $validated['promotion_type_id'],
            'evaluated_is_eligible' => $validated['evaluated_is_eligible'],
            'is_proposed' => $validated['is_proposed'],
            'rating_promotion_comment' => $validated['rating_promotion_comment'],
            'updated_by' => $validated['updated_by']
        ]);
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function delete(string $promotion_id): void
    {
        $promotion = Promotion::findOrFail($promotion_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($promotion->rating_id))) throw new CantUpdateValidatedRatingException();
        $promotion->delete();
    }

}
