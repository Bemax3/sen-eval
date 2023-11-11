<?php

namespace App\Services\Rating;

use App\Exceptions\Goal\GoalMarkExceedMarkingException;
use App\Exceptions\Goal\GoalsMarkingExceededException;
use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\Rating\UserCantEvaluateHimselfException;
use App\Models\Rating\Goal;
use App\Models\Rating\Rating;
use App\Models\Settings\SkillType;
use Carbon\Carbon;

class GoalService
{

    /**
     * @throws GoalsMarkingExceededException
     */
    public function create($validated, $agent_id): void
    {
        if (!$this->checkMarking($agent_id, $validated['phase_id'], $validated['goal_marking'])) {
            throw new GoalsMarkingExceededException();
        }
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

    }

    public function checkMarking($agent_id, $phase_id, $goal_marking): bool
    {
        $check = Goal::where('evaluated_id', '=', $agent_id)->where('phase_id', '=', $phase_id)->sum('goal_marking');
        if (($check + $goal_marking) > SkillType::GOALS_MARKING) return false;
        return true;
    }

    /**
     * @throws UserCantEvaluateHimselfException
     */
    public function updateMark($validated, $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        if ($goal->evaluator_id !== \Auth::id()) throw new UserCantEvaluateHimselfException();
        (new RatingService())->lowerMark($validated['rating_id'], $goal->goal_mark);
        $goal->update($validated);
        (new RatingService())->raiseMark($validated['rating_id'], $goal->goal_mark);
    }

    /**
     * @throws GoalsMarkingExceededException
     * @throws GoalMarkExceedMarkingException
     */
    public function update(mixed $validated, string $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        if (!$this->checkMarking($goal->evaluated_id, $validated['phase_id'], $validated['goal_marking'] - $goal->goal_marking)) {
            throw new GoalsMarkingExceededException();
        }
        if ($validated['goal_marking'] <= $goal->goal_mark) throw new GoalMarkExceedMarkingException();
        $goal->update([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'evaluation_period_id' => $validated['evaluation_period_id'],
            'goal_marking' => $validated['goal_marking'],
            'phase_id' => $validated['phase_id'],
            'goal_rate' => $validated['goal_rate'],
        ]);
    }

    /**
     * @throws NotEnoughGoalsException
     */
    public function destroy(string $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        $rating = Rating::where('phase_id', '=', $goal->phase_id)
            ->where('evaluated_id', '=', $goal->evaluated_id)
            ->where('evaluator_id', '=', $goal->evaluator_id)->first();
        if (!$this->checkGoals($rating, 1)) throw new NotEnoughGoalsException();
        $goal->delete();
    }

    public function checkGoals($rating, $offset = 0): bool
    {
        return (Goal::where('phase_id', '=', $rating->phase_id)
                    ->where('evaluator_id', '=', $rating->evaluator_id)
                    ->where('evaluated_id', '=', $rating->evaluated_id)
                    ->count() - $offset) >= $rating->phase->phase_min_goals;
    }

    public function updateAgentComment(mixed $validated, string $id): void
    {
        $goal = Goal::findOrFail($id);
        $goal->update($validated);
    }

}
