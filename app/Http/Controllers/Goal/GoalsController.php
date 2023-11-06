<?php

namespace App\Http\Controllers\Goal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveGoalRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Rating\Goal;
use App\Services\Rating\RatingService;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Exception;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class GoalsController extends Controller
{
    public function index() {
        return Inertia::render('Goals/GoalsList',[
            'goals' => Goal::where('evaluated_id', '=',\Auth::id())->with('phase','period')->paginate(10)
        ]);
    }

    public function edit(string $id) {
        try {
            return Inertia::render('Goals/SaveGoal',[
                'goal' => Goal::with('phase')->findOrFail($id)
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    public function update(SaveGoalRequest $request,string $id) {
        try {
            $goal = Goal::findOrFail($id);
            $goal->update($request->validated());
            alert_success('Objectif enregistré');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement, réessayer plus tard.');
        } finally {
            return redirect()->back();
        }
    }

    public function updateMark(SaveGoalRequest $request,string $id) {
        try {
            $goal = Goal::findOrFail($id);
            if($goal->evaluator_id !== \Auth::id()) {
                alert_error('Vous ne pouvez pas vous donner de note !');
                return redirect()->back();
            }
            $data = $request->validated();
            (new RatingService())->lowerMark($data['rating_id'],$goal->goal_mark);
            $goal->update($data);
            (new RatingService())->raiseMark($data['rating_id'],$goal->goal_mark);
            alert_success('Objectif enregistré');
        }catch (\Exception $e) {
            alert_error('Erreur lors de l\'enregistrement, réessayer plus tard.');
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
