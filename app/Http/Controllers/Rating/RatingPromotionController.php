<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingPromotionRequest;
use App\Models\Rating\Promotion;
use App\Models\Rating\Rating;
use App\Models\Settings\PromotionType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatingPromotionController extends Controller
{
    public function index(string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingPromotions',[
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => PromotionType::where('promotion_type_is_active','=',1)->get(),
            'promotions' => $rating->promotions()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingPromotionRequest $request,string $rating_id) {
        try {
            $data = $request->validated();
            $rating = Rating::findOrFail($rating_id);
            if ($rating->evaluator_id !== \Auth::id()) {
                alert_error('Vous ne pouvez pas créer cette demande.');
                return redirect()->back();
            }
            $promotion = Promotion::where('promotion_type_id','=',$data['promotion_type_id'])->where('rating_id','=',$rating_id)->first();
            if(!$promotion)
                Promotion::create([
                    'rating_id' => $rating_id,
                    'promotion_type_id' => $data['promotion_type_id'],
                    'evaluated_is_eligible' => $data['evaluated_is_eligible'],
                ]);
            else
                $promotion->update([
                    'promotion_type_id' => $data['promotion_type_id'],
                    'evaluated_is_eligible' => $data['evaluated_is_eligible'],
                ]);
            alert_success('Promotion enregistré avec succès.');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de la promotion');
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id,string $promotion_id) {
        try {
            Promotion::findOrFail($promotion_id)->delete();
            alert_success('Vous avez annuler la promotion.');
        }catch(\Exception) {
            alert_error('Erreur lors de l\'annulation de la promotion');
        } finally {
            return redirect()->back();
        }
    }
}
