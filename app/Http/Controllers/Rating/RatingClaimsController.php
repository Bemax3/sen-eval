<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingClaimRequest;
use App\Models\Rating\Claim;
use App\Models\Rating\Rating;
use App\Models\Settings\ClaimType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatingClaimsController extends Controller
{
    public function index(string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingClaims',[
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => ClaimType::where('claim_type_is_active','=',1)->get(),
            'claims' => $rating->claims()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingClaimRequest $request,string $rating_id) {
        try {
            $data = $request->validated();
            $sanction = Claim::where('claim_type_id','=',$data['claim_type_id'])->where('rating_id','=',$rating_id)->first();
            $rating = Rating::findOrFail($rating_id);
            if ($rating->evaluated_id !== \Auth::id()) {
                alert_error('Vous ne pouvez pas faire de réclamation.');
                return redirect()->back();
            }
            if(!$sanction)
                $sanction = Claim::create([
                    'rating_id' => $rating_id,
                    'claim_type_id' => $data['claim_type_id'],
                ]);
            alert_success('Réclamation enregistré avec succès.');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de la réclamation');
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id,string $sanction_id) {
        try {
            Claim::findOrFail($sanction_id)->delete();
            alert_success('Vous avez annuler la réclamation.');
        }catch(\Exception) {
            alert_error('Erreur lors de l\'annulation de la réclamation');
        } finally {
            return redirect()->back();
        }
    }
}
