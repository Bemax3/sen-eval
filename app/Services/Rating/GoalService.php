<?php

namespace App\Services\Rating;

use App\Exceptions\Goal\ExpectedDateCantBeAfterTheEvaluationException;
use App\Exceptions\Goal\GoalMarkExceedMarkingException;
use App\Exceptions\Goal\GoalsMarkingExceededException;
use App\Exceptions\Goal\PeriodGoalsCountLimitReachedException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\GoalRateCantBeLowerThanBeforeException;
use App\Exceptions\Rating\UserCantEvaluateHimselfException;
use App\Models\Phase\EvaluationPeriod;
use App\Models\Rating\Goal;
use App\Models\Rating\GoalHistory;
use App\Models\Rating\Rating;
use App\Models\Settings\SkillType;
use Carbon\Carbon;

class GoalService
{

    /**
     * @throws UserCantEvaluateHimselfException
     * @throws CantUpdateValidatedRatingException
     */
    public function updateMark($validated, $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($validated['rating_id']))) throw new CantUpdateValidatedRatingException();
        if ($goal->evaluator_id !== \Auth::id()) throw new UserCantEvaluateHimselfException();
        (new RatingService())->lowerMark($validated['rating_id'], $goal->goal_mark);
        $goal->update($validated);
        (new RatingService())->raiseMark($validated['rating_id'], $goal->goal_mark);
    }

    /**
     * @throws GoalsMarkingExceededException
     * @throws GoalMarkExceedMarkingException
     * @throws GoalRateCantBeLowerThanBeforeException
     */
    public function update(mixed $validated, string $goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);

        if (!$this->checkMarking($goal->evaluated_id, $validated['phase_id'], $validated['goal_marking'] - $goal->goal_marking)) throw new GoalsMarkingExceededException();

        if ($validated['goal_marking'] < $goal->goal_mark) throw new GoalMarkExceedMarkingException();

        if ($validated['goal_rate'] < $goal->goal_rate) throw new GoalRateCantBeLowerThanBeforeException();

        $goal->update([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'evaluation_period_id' => $validated['evaluation_period_id'],
            'goal_marking' => $validated['goal_marking'],
            'phase_id' => $validated['phase_id'],
            'goal_rate' => $validated['goal_rate'],
            'updated_by' => \Auth::id()
        ]);

        GoalHistory::create([
            'goal_id' => $goal->goal_id,
            'goal_rate' => $goal->goal_rate,
            'comment' => $validated['comment'] ?? '',
            'updated_by' => \Auth::id()
        ]);
    }

    public function checkMarking($agent_id, $phase_id, $goal_marking): bool
    {
        $check = Goal::where('evaluated_id', '=', $agent_id)->where('phase_id', '=', $phase_id)->sum('goal_marking');
        if (($check + $goal_marking) > SkillType::GOALS_MARKING) return false;
        return true;
    }

    /**
     * @throws GoalsMarkingExceededException
     * @throws PeriodGoalsCountLimitReachedException
     * @throws ExpectedDateCantBeAfterTheEvaluationException
     */
    public function create($validated, $agent_id): void
    {
        if (!$this->checkMarking($agent_id, $validated['phase_id'], $validated['goal_marking'])) throw new GoalsMarkingExceededException();

        if (!$this->checkPeriodGoalsCount($validated['evaluation_period_id'], $agent_id)) throw new PeriodGoalsCountLimitReachedException();

        // if (!$this->checkDateAndPeriod($validated['evaluation_period_id'], $validated['goal_expected_date'])) throw new ExpectedDateCantBeAfterTheEvaluationException();

        $goal = Goal::create([
            'goal_name' => $validated['goal_name'],
            'goal_expected_result' => $validated['goal_expected_result'],
            'goal_expected_date' => Carbon::createFromDate($validated['goal_expected_date'])->toDateTimeString(),
            'goal_means_available' => $validated['goal_means_available'],
            'evaluation_period_id' => $validated['evaluation_period_id'],
            'goal_marking' => $validated['goal_marking'],
            'phase_id' => $validated['phase_id'],
            'evaluator_id' => \Auth::id(),
            'evaluated_id' => $agent_id,
            'updated_by' => \Auth::id()
        ]);

        GoalHistory::create([
            'goal_id' => $goal->goal_id,
            'goal_rate' => 0,
            'updated_by' => \Auth::id()
        ]);

    }

    public function checkPeriodGoalsCount($period_id, $agent_id): bool
    {
        // return Goal::where('evaluation_period_id', '=', $period_id)->where('evaluated_id', '=', $agent_id)->count() <= 3;
        //Code Cheikh
        return Goal::where('evaluation_period_id', '=', $period_id)->where('evaluated_id', '=', $agent_id)->count() <= 7;
    }

    public function checkDateAndPeriod($period_id, $date): bool
    {
        $period = EvaluationPeriod::findOrFail($period_id);
        if (Carbon::createFromDate($date)->between(Carbon::createFromDate($period->evaluation_period_start)->subMonth(5), $period->evaluation_period_end)) return true;
        return false;

    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function destroy($goal_id): void
    {
        $goal = Goal::findOrFail($goal_id);
        $rating = Rating::where('phase_id', '=', $goal->phase_id)
            ->where('evaluated_id', '=', $goal->evaluated_id)
            ->where('evaluator_id', '=', $goal->evaluator_id)->first();
        if (!$rating) throw new ModelNotFoundException('Resource Introuvable.');
        if ($rating->rating_is_validated) throw new CantUpdateValidatedRatingException();
        if ($rating->validators()->where('validator_id', '=', \Auth::id())->first()->has_validated) throw new CantUpdateValidatedRatingException();
        (new RatingService())->lowerMark($rating->rating_id, $goal->goal_mark);
        GoalHistory::where('goal_id', '=', $goal->goal_id)->delete();
        $goal->delete();
    }

    public function checkGoals($rating, $offset = 0): bool
    {
        // dd($rating->goals()->sum('goal_marking'));
        return ($rating->goals()
                    ->count() - $offset) >= $rating->phase->phase_min_goals && $rating->goals()->sum('goal_marking') == SkillType::GOALS_MARKING;
    }

    public function updateAgentComment(mixed $validated, string $id): void
    {
        $goal = Goal::findOrFail($id);
        $goal->update(['goal_rate' => $validated['goal_rate']]);
        GoalHistory::create([
            'goal_id' => $goal->goal_id,
            'goal_rate' => $goal->goal_rate,
            'comment' => $validated['comment'] ?? '',
            'updated_by' => \Auth::id()
        ]);
    }

}
