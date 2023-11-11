<?php

namespace App\Http\Controllers\Agent;

use App\Exceptions\Goal\GoalMarkExceedMarkingException;
use App\Exceptions\Goal\GoalsMarkingExceededException;
use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveAgentGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Rating\Goal;
use App\Models\User;
use App\Services\Rating\GoalService;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentGoalsController extends Controller
{

    public function __construct(private readonly GoalService $goalService)
    {
    }

    public function index(string $id)
    {
        try {
            return Inertia::render('Agents/Goal/AgentGoals', [
                'agent' => User::with('org')->findOrFail($id),
                'goals' => Goal::where('evaluator_id', '=', \Auth::id())->where('evaluated_id', '=', $id)->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(string $agent_id, string $goal_id)
    {
        try {
            return Inertia::render('Agents/Goal/SaveAgentGoal', [
                'agent' => User::with('org')->findOrFail($agent_id),
                'phases' => Phase::where('phase_is_active', '=', 1)->with('periods')->get(),
                'goal' => Goal::findOrFail($goal_id)
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
        } catch (GoalsMarkingExceededException $e) {
            alert_error($e->getMessage());
        } catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement de l\'objectif');
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
        } catch (GoalsMarkingExceededException|GoalMarkExceedMarkingException|UnknownException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function destroy(string $agent_id, string $goal_id)
    {
        try {
            $this->goalService->destroy($goal_id);
            alert_success('Objectif Supprimé avec succès.');
        } catch (NotEnoughGoalsException|ModelNotFoundException|UnknownException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function search(SearchRequest $request, string $agent_id)
    {
//        ray($agent_id);
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(Goal::class, function (ModelSearchAspect $aspect) use ($data, $agent_id) {
                    foreach ($data['fields'] as $field) $aspect->addSearchableAttribute($field);
                    $aspect->where('evaluated_id', '=', $agent_id);
                    $aspect->where('evaluator_id', '=', \Auth::id());
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
