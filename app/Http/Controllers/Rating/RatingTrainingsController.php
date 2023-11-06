<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingTrainingRequest;
use App\Models\Rating\Rating;
use App\Models\Rating\Training;
use App\Models\Settings\TrainingType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RatingTrainingsController extends Controller
{
    public function index(string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->findOrFail($rating_id);
        return Inertia::render('Rating/RatingTrainings',[
            'agent' => User::with('org')->findOrFail($rating->evaluated_id),
            'rating' => $rating,
            'types' => TrainingType::where('training_type_is_active','=',1)->get(),
            'trainings' => $rating->trainings()->with('type')->paginate(10)
        ]);
    }


    public function store(SaveRatingTrainingRequest $request,string $rating_id) {
        try {
            $data = $request->validated();
            $training = Training::where('training_type_id','=',$data['training_type_id'])->where('rating_id','=',$rating_id)->first();
            if(!$training)
                $training = Training::create([
                    'rating_id' => $rating_id,
                    'training_type_id' => $data['training_type_id'],
                ]);
            if($request->has('asked_by_evaluator')) $training->update(['asked_by_evaluator' => $data['asked_by_evaluator']]);
            if($request->has('asked_by_evaluated')) $training->update(['asked_by_evaluated' => $data['asked_by_evaluated']]);

            alert_success('Demande de formation enregistré avec succès.');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de la demande');
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveRatingTrainingRequest $request, string $rating_id,string $training_id) {
        try {
            $data = $request->validated();
            $training = Training::findOrFail($training_id);
            if($request->has('asked_by_evaluator')) $training->update(['asked_by_evaluator' => $data['asked_by_evaluator']]);
            if($request->has('asked_by_evaluated')) $training->update(['asked_by_evaluated' => $data['asked_by_evaluated']]);

            if (!$training->asked_by_evaluated &&  !$training->asked_by_evaluator) $training->delete();
            alert_success('Vous avez annuler votre demande pour cette formation.');
        }catch (\Exception) {
            alert_error('Erreur lors de l\'annulation de la demande');
        } finally {
            return redirect()->back();
        }
    }
}
