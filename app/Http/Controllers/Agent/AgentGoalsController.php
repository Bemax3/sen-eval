<?php

namespace App\Http\Controllers\Agent;

use App\Exceptions\Goal\ExpectedDateCantBeAfterTheEvaluationException;
use App\Exceptions\Goal\GoalMarkExceedMarkingException;
use App\Exceptions\Goal\GoalsMarkingExceededException;
use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\Goal\PeriodGoalsCountLimitReachedException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\GoalRateCantBeLowerThanBeforeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveAgentGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Rating\Goal;
use App\Models\User;
use App\Services\Rating\GoalService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentGoalsController extends Controller
{

    public function __construct(private readonly GoalService $goalService)
    {
    }

    public function index(Request $request, string $id)
    {
        $phase = $request->get('phase_id');
        if (!isset($phase) || $phase == -1) $goals = Goal::where('evaluator_id', '=', Auth::id())->where('evaluated_id', '=', $id)->with('phase', 'period')->paginate(10);
        else $goals = Goal::where('evaluator_id', '=', Auth::id())->where('evaluated_id', '=', $id)->where('phase_id', '=', $phase)->with('phase', 'period')->paginate(10);
        try {
            return Inertia::render('Agents/Goal/AgentGoals', [
                'agent' => User::with('org')->findOrFail($id),
                'goals' => $goals,
                'phases' => Phase::all(),
                'phase_id' => $phase
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(string $agent_id, string $goal_id)
    {
        try {
            $goal = Goal::findOrFail($goal_id);
            return Inertia::render('Agents/Goal/SaveAgentGoal', [
                'agent' => User::with('org')->findOrFail($agent_id),
                'phases' => Phase::with('periods')->get(),
                'goal' => $goal,
                'history' => $goal->history()->with('updated_by')->get()
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function store(SaveAgentGoalRequest $request, string $id)
    {
        try {
            $this->goalService->create($request->validated(), $id);
            alert_success('Objectif Enregistré avec succès');
        } catch (GoalsMarkingExceededException|PeriodGoalsCountLimitReachedException|ExpectedDateCantBeAfterTheEvaluationException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function create(string $id)
    {
        try {
            return Inertia::render('Agents/Goal/SaveAgentGoal', [
                'agent' => User::with('org')->findOrFail($id),
                'phases' => Phase::where('phase_is_active', '=', 1)->with('periods')->get(),
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function update(SaveAgentGoalRequest $request, string $id, string $goal_id)
    {
        try {
            $this->goalService->update($request->validated(), $goal_id);
            alert_success('Objectif Enregistré avec succès.');
        } catch (GoalsMarkingExceededException|GoalMarkExceedMarkingException|GoalRateCantBeLowerThanBeforeException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $agent_id, string $goal_id)
    {
        try {

            $this->goalService->destroy(intval($goal_id));
            alert_success('Objectif Supprimé avec succès.');
        } catch (NotEnoughGoalsException|ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function search(SearchRequest $request, string $agent_id)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(Goal::class, function (ModelSearchAspect $aspect) use ($data, $agent_id) {
                    foreach ($data['fields'] as $field) $aspect->addSearchableAttribute($field);
                    $aspect->where('evaluated_id', '=', $agent_id);
                    $aspect->where('evaluator_id', '=', Auth::id());
                })
                ->limitAspectResults(20)
                ->search($data['keyword']);
            $result = [];
            foreach ($searchResults as $sr) {
                $result[] = $sr->searchable;
            }
            return response()->json($result);
        } catch (Exception) {
            return response()->json();
        }
    }
}
