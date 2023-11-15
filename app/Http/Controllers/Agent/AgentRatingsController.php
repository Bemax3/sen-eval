<?php

namespace App\Http\Controllers\Agent;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\AgentHasRatingForCurrentPhaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveRatingRequest;
use App\Models\Phase\Phase;
use App\Models\Rating\Goal;
use App\Models\Rating\Rating;
use App\Models\Rating\Validator;
use App\Models\Settings\SkillType;
use App\Models\User;
use App\Services\Rating\RatingService;
use App\Services\Security\UserService;
use Inertia\Inertia;

class AgentRatingsController extends Controller
{
    public function __construct(private readonly RatingService $ratingService)
    {
    }

    public function index(string $agent_id)
    {
        try {
            return Inertia::render('Agents/Rating/AgentRatings', [
                'agent' => User::with('org')->findOrFail($agent_id),
                'ratings' => Rating::where('evaluator_id', '=', \Auth::id())->where('evaluated_id', '=', $agent_id)->with('evaluator', 'phase', 'evaluated')->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function show(string $agent_id, string $rating_id)
    {
        try {
            $user = User::with('n1')->findOrFail(\Auth::id());
            $rating = Rating::with('phase', 'evaluator', 'evaluated')->withSum('specific_skills', 'rating_skill_mark')->withSum('general_skills', 'rating_skill_mark')->findOrFail($rating_id);
            return Inertia::render('Agents/Rating/AgentRatingSkills', [
                'rating' => $rating,
                'agent' => $rating->evaluated,
                'specific_skill_types' => $rating->phase->active_specific_skills()->get(),
                'marking' => ['specific' => SkillType::SPECIFIC_MARKING, 'general' => SkillType::GENERAL_MARKING, 'perf' => SkillType::GOALS_MARKING],
                'specific_skills' => $rating->specific_skills()->get(),
                'skills' => $rating->general_skills()->get(),
                'others' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : [],
                'n1' => $user->n1,
                'validators' => Validator::where('rating_id', '=', $rating->rating_id)->with('user')->get(),
                'goals' => Goal::where('phase_id', $rating->phase_id)->where('evaluated_id', $rating->evaluated_id)->with('period', 'phase')->get(),
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function store(SaveRatingRequest $request, string $agent_id)
    {
        try {
            $rating = $this->ratingService->create($request->validated());
            alert_success('Évaluation crée avec succès.');
            return redirect()->route('agent-ratings.show', ['agent' => $agent_id, 'agent_rating' => $rating->rating_id]);
        } catch (AgentHasRatingForCurrentPhaseException|ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function create(string $agent_id)
    {
        try {
            return Inertia::render('Agents/Rating/SaveRating', [
                'agent' => User::with('org')->findOrFail($agent_id),
                'phases' => Phase::where('phase_is_active', '=', 1)->get(),
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

}
