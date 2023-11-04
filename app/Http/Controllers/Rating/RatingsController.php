<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingCommentsRequest;
use App\Models\Rating\Rating;
use App\Models\Rating\Goal;
use App\Models\Settings\SkillType;
use App\Models\User;
use App\Services\Rating\RatingService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Exception;

class RatingsController extends Controller
{
    public function __construct(private readonly RatingService $ratingService){}

    public function index() {
        return Inertia::render('Rating/RatingsList',[
            'user' => User::with('org')->findOrFail(\Auth::id()),
            'ratings' => Rating::where('evaluated_id','=',\Auth::id())->with('evaluator','phase','evaluated')->paginate(10)
        ]);
    }

    public function show(string $rating_id) {
        $rating = Rating::with('phase','evaluator')->withSum('specific_skills','rating_skill_mark')->withSum('general_skills','rating_skill_mark')->findOrFail($rating_id);
        $agent = User::with('org')->findOrFail(\Auth::id());
        return Inertia::render('Rating/RatingSkills',[
            'rating' => $rating,
            'agent' => $agent,
            'marking' => ['specific' => SkillType::SPECIFIC_MARKING,'general' => SkillType::GENERAL_MARKING,'perf' => SkillType::GOALS_MARKING],
            'specific_skills' => $rating->specific_skills()->get(),
            'skills' => $rating->general_skills()->get(),
            'goals' => Goal::where('phase_id',$rating->phase_id)->where('evaluated_id',$rating->evaluated_id)->with('period','phase')->get(),
        ]);
    }

    public function update(SaveRatingCommentsRequest $request,string $rating_id) {
        try {
            $this->ratingService->addComment($request->validated(),$rating_id);
            alert_success('Commentaire enregistré avec succès.');
            return redirect()->back();
        }catch (Exception) {
            alert_error('Erreur lors de l\'enregistrement du commentaire.');
            return redirect()->back();
        }
    }
}
