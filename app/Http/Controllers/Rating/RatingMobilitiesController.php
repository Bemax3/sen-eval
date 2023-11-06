<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingMobilityRequest;
use App\Models\Rating\Mobility;
use App\Models\Rating\Rating;
use App\Models\Settings\MobilityType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatingMobilitiesController extends Controller
{
    public function index(string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingMobilities',[
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => MobilityType::where('mobility_type_is_active','=',1)->get(),
            'mobilities' => $rating->mobilities()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingMobilityRequest $request,string $rating_id) {
        try {
            $data = $request->validated();
            $mobility = Mobility::create([
                'rating_id' => $rating_id,
                'mobility_type_id' => $data['mobility_type_id'],
                'rating_mobility_title' => $data['rating_mobility_title'],
            ]);
            if($request->has('asked_by_evaluator')) $mobility->update(['asked_by_evaluator' => $data['asked_by_evaluator']]);
            if($request->has('asked_by_evaluated')) $mobility->update(['asked_by_evaluated' => $data['asked_by_evaluated']]);

            alert_success('Demande de mobilité enregistré avec succès.');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de la demande');
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingMobilityRequest $request, string $rating_id,string $mobility_id) {
        try {
            $data = $request->validated();
            $mobility = Mobility::findOrFail($mobility_id);
            $mobility->update([
                'rating_mobility_title' => $data['rating_mobility_title']
            ]);
            if($request->has('asked_by_evaluator')) $mobility->update(['asked_by_evaluator' => $data['asked_by_evaluator']]);
            if($request->has('asked_by_evaluated')) $mobility->update(['asked_by_evaluated' => $data['asked_by_evaluated']]);
            alert_success('Demande de mobilité modifié.');
        }catch (\Exception) {
            alert_error('Erreur lors de la modification de la demande');
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $rating_id,string $mobility_id) {
        try {
            Mobility::findOrFail($mobility_id)->delete();
            alert_success('Vous avez annuler votre demande pour cette mobilité.');
        }catch(\Exception) {
            alert_error('Erreur lors de l\'annulation de la demande');
        } finally {
            return redirect()->back();
        }
    }
}
