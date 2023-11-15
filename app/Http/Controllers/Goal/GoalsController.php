<?php

namespace App\Http\Controllers\Goal;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\UserCantEvaluateHimselfException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Rating\Goal;
use App\Services\Rating\GoalService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Exception;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class GoalsController extends Controller
{
    public function __construct(private readonly GoalService $goalService)
    {
    }

    public function index(Request $request)
    {
        $phase = $request->get('phase_id');
        if (!isset($phase) || $phase == -1) $goals = Goal::where('evaluated_id', '=', \Auth::id())->with('phase', 'period')->paginate(10);
        else $goals = Goal::where('evaluated_id', '=', \Auth::id())->where('phase_id', '=', $phase)->with('phase', 'period')->paginate(10);
        return Inertia::render('Goals/GoalsList', [
            'goals' => $goals,
            'phases' => Phase::all(),
            'phase_id' => $phase
        ]);
    }

    public function edit(string $id)
    {
        try {
            $goal = Goal::with('phase', 'period')->findOrFail($id);
            return Inertia::render('Goals/SaveGoal', [
                'goal' => $goal,
                'history' => $goal->history()->with('updated_by')->get()
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function updateMark(SaveGoalRequest $request, string $id)
    {
        try {
            $this->goalService->updateMark($request->validated(), $id);
            alert_success('Objectif enregistré');
        } catch (UserCantEvaluateHimselfException|ModelNotFoundException|UnknownException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function update(SaveGoalRequest $request, string $id)
    {
        try {
            $this->goalService->updateAgentComment($request->validated(), $id);
            alert_success('Objectif enregistré');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            ray($request->validated());
            $searchResults = (new Search())
                ->registerModel(Goal::class, function (ModelSearchAspect $aspect) use ($data) {
                    foreach ($data['fields'] as $field) $aspect->addSearchableAttribute($field);
                    $aspect->where('evaluated_id', '=', \Auth::id());
                    $aspect->with('phase');
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
