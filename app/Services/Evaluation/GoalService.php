<?php

namespace App\Services\Evaluation;

use App\Models\Evaluation\Goal;
use Carbon\Carbon;

class GoalService
{

    public function create($validated,$agent_id): void
    {
        Goal::create([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'phase_id' => $validated['phase_id'],
            'evaluator_id' => \Auth::id(),
            'evaluated_id' => $agent_id
        ]);
    }

    public function update(mixed $validated, string $id, string $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        $goal->update([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'phase_id' => $validated['phase_id'],
            'evaluator_id' => \Auth::id(),
            'evaluated_id' => $id
        ]);
    }

}
