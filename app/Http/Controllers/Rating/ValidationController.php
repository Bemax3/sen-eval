<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Models\Rating\Goal;
use App\Models\Rating\Rating;
use App\Models\Settings\SkillType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ValidationController extends Controller
{
    public function index() {
        return Inertia::render('Validation/RatingsList',[
            'ratings' => Rating::where('validator_id','=',\Auth::id())->with('evaluator','phase','evaluated')->paginate(10)
        ]);
    }

    public function show(string $rating_id) {
        $rating = Rating::with('phase','evaluator')->withSum('specific_skills','rating_skill_mark')->withSum('general_skills','rating_skill_mark')->findOrFail($rating_id);
        if($rating->validator_id !== \Auth::id()) {
            alert_error('Vous n\'êtes pas autorisé a voir cette évaluation.');
            return redirect()->back();
        }
        return Inertia::render('Validation/ValidateRating',[
            'rating' => $rating,
            'agent' => $rating->evaluated,
            'marking' => ['specific' => SkillType::SPECIFIC_MARKING,'general' => SkillType::GENERAL_MARKING,'perf' => SkillType::GOALS_MARKING],
            'specific_skills' => $rating->specific_skills()->get(),
            'skills' => $rating->general_skills()->get(),
            'goals' => Goal::where('phase_id',$rating->phase_id)->where('evaluated_id',$rating->evaluated_id)->with('period','phase')->get(),
        ]);
    }
}
