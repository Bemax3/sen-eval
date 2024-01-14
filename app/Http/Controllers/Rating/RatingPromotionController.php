<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\AgentIsNotEligibleForAdvancementException;
use App\Exceptions\Rating\AgentIsNotEligibleForPromotionException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\PromotionAlreadyExistException;
use App\Exceptions\UnauthorizedActionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingPromotionRequest;
use App\Models\Rating\Rating;
use App\Models\Settings\PromotionType;
use App\Models\User;
use App\Services\Rating\PromotionService;
use Inertia\Inertia;

class RatingPromotionController extends Controller
{
    public function __construct(private readonly PromotionService $promotionService)
    {
    }

    public function index(string $rating_id)
    {
        $rating = Rating::with('phase', 'evaluator', 'evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingPromotions', [
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => PromotionType::where('promotion_type_is_active', '=', 1)->get(),
            'promotions' => $rating->promotions()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingPromotionRequest $request, string $rating_id)
    {
        try {
            $this->promotionService->create($request->validated(), $rating_id);
            alert_success('Promotion enregistré avec succès.');
        } catch (UnauthorizedActionException|PromotionAlreadyExistException|CantUpdateValidatedRatingException|AgentIsNotEligibleForPromotionException|AgentIsNotEligibleForAdvancementException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingPromotionRequest $request, string $rating_id, string $rating_promotion_id)
    {
        try {
            $this->promotionService->update($request->validated(), $rating_promotion_id);
            alert_success('Promotion enregistré avec succès.');
        } catch (ModelNotFoundException|UnauthorizedActionException|PromotionAlreadyExistException|CantUpdateValidatedRatingException|AgentIsNotEligibleForPromotionException|AgentIsNotEligibleForAdvancementException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id, string $promotion_id)
    {
        try {
            $this->promotionService->delete($promotion_id);
            alert_success('Vous avez annuler la promotion.');
        } catch (ModelNotFoundException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
