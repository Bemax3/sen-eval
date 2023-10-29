<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\SaveAgentGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Evaluation\Goal;
use App\Models\Phase\Phase;
use App\Models\User;
use App\Services\Evaluation\GoalService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentsGoalsController extends Controller
{

    public function __construct(private readonly GoalService $goalService){}

    public function index(string $id) {
        return Inertia::render('Evaluation/Agents/AgentGoals',[
            'agent' => User::with('org')->findOrFail($id),
            'goals' => Goal::where('evaluator_id','=',\Auth::id())->where('evaluated_id','=',$id)->paginate(10)
        ]);
    }

    public function create(string $id) {
        return Inertia::render('Evaluation/Agents/SaveAgentGoal',[
            'agent' =>  User::with('org')->findOrFail($id),
            'phases' => Phase::all(),
        ]);
    }

    public function edit(string $agent_id,string $goal_id) {
        return Inertia::render('Evaluation/Agents/SaveAgentGoal',[
            'agent' =>  User::with('org')->findOrFail($agent_id),
            'phases' => Phase::all(),
            'goal' => Goal::findOrFail($goal_id)
        ]);
    }

    public function store(SaveAgentGoalRequest $request,string $id) {
        try {
//            ray($request->validated());
            $this->goalService->create($request->validated(),$id);
            alert_success('Objectif Enregistré avec succès');
        }catch (\Exception) {
            alert_error('Erreur lors de l\'enregistrement de l\'objectif');
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveAgentGoalRequest $request,string $id,string $goal_id) {
        try {
            $this->goalService->update($request->validated(),$id,$goal_id);
            alert_success('Objectif Enregistré avec succès');
        }catch (\Exception) {
            alert_error('Erreur lors de l\'enregistrement de l\'objectif');
        } finally {
            return redirect()->back();
        }
    }

    public function search(SearchRequest $request,string $agent_id)
    {
//        ray($agent_id);
        try {
            $data = $request->validated();
        ray($request->validated());
            $searchResults = (new Search())
                ->registerModel(Goal::class, function  (ModelSearchAspect $aspect) use ($data,$agent_id) {
                    foreach ($data['fields'] as $field) $aspect->addSearchableAttribute($field);
                    $aspect->where('evaluated_id','=',$agent_id);
                    $aspect->where('evaluator_id','=',\Auth::id());
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
