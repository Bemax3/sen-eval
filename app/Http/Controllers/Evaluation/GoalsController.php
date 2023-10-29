<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\SaveGoalRequest;
use App\Models\Evaluation\Goal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PHPUnit\Framework\MockObject\Exception;

class GoalsController extends Controller
{
    public function index() {
        return Inertia::render('Evaluation/Goals/GoalsList',[
            'goals' => Goal::where('evaluated_id', '=',\Auth::id())->paginate(10)
        ]);
    }

    public function edit(string $id) {
        try {
            return Inertia::render('Evaluation/Goals/SaveGoal',[
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
            alert_success('Objectif Accepté');
        }catch (\Exception) {
            alert_error('Erreur lors de l\'acceptation, réessayer plus tard.');
        } finally {
            return redirect()->back();
        }


    }


}
