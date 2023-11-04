<?php

namespace App\Services\Rating;

use App\Models\Rating\Goal;
use App\Models\Settings\SkillType;
use Carbon\Carbon;

class GoalService
{

    public function create($validated,$agent_id): string
    {
        if(!$this->checkMarking($agent_id,$validated['phase_id'],$validated['goal_marking'])) return 'exceed';
        Goal::create([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'evaluation_period_id' => $validated['evaluation_period_id'],
            'goal_marking' => $validated['goal_marking'],
            'phase_id' => $validated['phase_id'],
            'evaluator_id' => \Auth::id(),
            'evaluated_id' => $agent_id
        ]);
        return 'ok';
    }

    public function update(mixed $validated, string $id, string $goal_id): string
    {
        $goal = Goal::findOrFail($goal_id);
        if(!$this->checkMarking($goal->evaluated_id,$validated['phase_id'], $validated['goal_marking'] - $goal->goal_marking )) return 'exceed';
        if($validated['goal_marking'] <= $goal->goal_mark) return 'exceed_mark';
        $goal->update([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'evaluation_period_id' => $validated['evaluation_period_id'],
            'goal_marking' => $validated['goal_marking'],
            'phase_id' => $validated['phase_id'],
            'evaluator_id' => \Auth::id(),
            'evaluated_id' => $id
        ]);
        return 'ok';
    }


    public function checkMarking($agent_id,$phase_id,$goal_marking) : bool
    {
        $check = Goal::where('evaluated_id' ,'=',$agent_id)->where('phase_id','=',$phase_id)->sum('goal_marking');
        if(($check + $goal_marking) > SkillType::GOALS_MARKING) return false;
        return true;
    }

}
