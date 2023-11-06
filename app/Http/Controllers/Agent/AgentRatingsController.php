<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingCommentsRequest;
use App\Http\Requests\Rating\SaveRatingRequest;
use App\Models\Rating\Rating;
use App\Models\Rating\Goal;
use App\Models\Phase\Phase;
use App\Models\Settings\SkillType;
use App\Models\User;
use App\Services\Rating\RatingService;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Exception;

class AgentRatingsController extends Controller
{
    public function __construct(private readonly RatingService $ratingService){}

    public function index(string $agent_id) {
        return Inertia::render('Agents/Rating/AgentRatings',[
            'agent' => User::with('org')->findOrFail($agent_id),
            'ratings' => Rating::where('evaluator_id','=',\Auth::id())->where('evaluated_id','=',$agent_id)->with('evaluator','phase','evaluated')->paginate(10)
        ]);
    }

    public function create(string $agent_id) {
        return Inertia::render('Agents/Rating/SaveRating',[
            'agent' => User::with('org')->findOrFail($agent_id),
            'phases' => Phase::where('phase_is_active','=',1)->get(),
        ]);
    }

    public function show(string $agent_id,string $rating_id) {
        $rating = Rating::with('phase','evaluator','evaluated')->withSum('specific_skills','rating_skill_mark')->withSum('general_skills','rating_skill_mark')->findOrFail($rating_id);
        return Inertia::render('Agents/Rating/AgentRatingSkills',[
            'rating' => $rating,
            'agent' => $rating->evaluated,
            'specific_skill_types' => $rating->phase->active_specific_skills()->get(),
            'marking' => ['specific' => SkillType::SPECIFIC_MARKING,'general' => SkillType::GENERAL_MARKING,'perf' => SkillType::GOALS_MARKING],
            'specific_skills' => $rating->specific_skills()->get(),
            'skills' => $rating->general_skills()->get(),
            'goals' => Goal::where('phase_id',$rating->phase_id)->where('evaluated_id',$rating->evaluated_id)->with('period','phase')->get(),
        ]);
    }

    public function store(SaveRatingRequest $request, string $agent_id) {
        try {
            $rating = $this->ratingService->create($request->validated());
            if (!$rating) {
                alert_error('Cet agent a déjà une évaluation pour l\'année choisi.');
                return redirect()->back();
            }
            alert_success('Rating crée avec succès.');
            return redirect()->route('agent-ratings.show',['agent' => $agent_id,'agent_rating' => $rating->rating_id]);
        }catch (Exception) {
            alert_error('Erreur lors de la création de l\'évaluation.');
            return redirect()->back();
        }
    }

}
