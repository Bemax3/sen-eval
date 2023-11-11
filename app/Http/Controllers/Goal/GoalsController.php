<?php

namespace App\Http\Controllers\Goal;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\UserCantEvaluateHimselfException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Rating\Goal;
use App\Services\Rating\GoalService;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Exception;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class GoalsController extends Controller
{
    public function __construct(private readonly GoalService $goalService)
    {
    }

    public function index()
    {
        return Inertia::render('Goals/GoalsList', [
            'goals' => Goal::where('evaluated_id', '=', \Auth::id())->with('phase', 'period')->paginate(10)
        ]);
    }

    public function edit(string $id)
    {
        try {
            return Inertia::render('Goals/SaveGoal', [
                'goal' => Goal::with('phase')->findOrFail($id)
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
