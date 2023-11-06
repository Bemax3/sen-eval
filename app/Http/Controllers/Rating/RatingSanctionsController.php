<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingSanctionRequest;
use App\Models\Rating\Mobility;
use App\Models\Rating\Rating;
use App\Models\Rating\Sanction;
use App\Models\Settings\SanctionType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatingSanctionsController extends Controller
{
    public function index(string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingSanctions',[
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => SanctionType::where('sanction_type_is_active','=',1)->get(),
            'sanctions' => $rating->sanctions()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingSanctionRequest $request,string $rating_id) {
        try {
            $data = $request->validated();
            $sanction = Sanction::where('sanction_type_id','=',$data['sanction_type_id'])->where('rating_id','=',$rating_id)->first();
            $rating = Rating::findOrFail($rating_id);
            if ($rating->evaluator_id !== \Auth::id()) {
                alert_error('Vous ne pouvez pas vous donner de sanction.');
                return redirect()->back();
            }
            if(!$sanction)
                $sanction = Sanction::create([
                    'rating_id' => $rating_id,
                    'sanction_type_id' => $data['sanction_type_id'],
                ]);
            alert_success('Demande de sanction enregistré avec succès.');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de la demande');
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id,string $sanction_id) {
        try {
            Sanction::findOrFail($sanction_id)->delete();
            alert_success('Vous avez annuler la sanction.');
        }catch(\Exception) {
            alert_error('Erreur lors de l\'annulation de la sanction');
        } finally {
            return redirect()->back();
        }
    }
}
