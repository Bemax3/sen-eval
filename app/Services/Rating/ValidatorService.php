<?php

namespace App\Services\Rating;

use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\CantValidateRatingOutOfEvaluationPeriodsException;
use App\Exceptions\Rating\EvaluatedHasNotValidatedException;
use App\Exceptions\Rating\EvaluatorHasNotValidatedException;
use App\Exceptions\Rating\NotEnoughSpecificSkillsException;
use App\Exceptions\Rating\NotRatedCorrectlyException;
use App\Exceptions\Rating\ValidatorAlreadyExistException;
use App\Mail\ValidatedRating;
use App\Models\Rating\Rating;
use App\Models\Rating\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ValidatorService
{
    public function createMultiple(array $validators, mixed $rating_id): void
    {
        foreach ($validators as $validator_id)
            Validator::create([
                'validator_id' => $validator_id,
                'rating_id' => $rating_id
            ]);
    }

    public function create($validator_id, $rating_id): void
    {
        Validator::create([
            'rating_id' => $rating_id,
            'validator_id' => $validator_id
        ]);

    }

    /**
     * @throws ValidatorAlreadyExistException
     * @throws EvaluatedHasNotValidatedException
     * @throws NotEnoughGoalsException
     * @throws NotEnoughSpecificSkillsException
     * @throws NotRatedCorrectlyException
     * @throws CantUpdateValidatedRatingException
     * @throws CantValidateRatingOutOfEvaluationPeriodsException
     * @throws EvaluatorHasNotValidatedException
     */
    public function update(string $validation, mixed $validated): void
    {
        // dd($validated['rating_validator_comment']);
        $validator = Validator::findOrFail($validation);

        $rating = Rating::findOrFail($validator->rating_id);

        if (!$this->checkForEvaluationPeriods($rating)) throw new CantValidateRatingOutOfEvaluationPeriodsException();

        if ($this->checkForAllValidation($rating)) throw new CantUpdateValidatedRatingException();

        if (isset($validated['remember']) && $validated['remember']) User::findOrFail(\Auth::id())->update(['n1_id' => $validated['new_validator']]);
        
        if (isset($validated['rating_validator_comment']))
            $validator->update([
                'rating_validator_comment' => $validated['rating_validator_comment']
            ]);

        //Code Cheikh -> Gestion entretien effectif
        if (isset($validated['has_talk']))
            $validator->update([
                'has_talk' => $validated['has_talk']
            ]);

        //End code Cheikh

        if (isset($validated['new_validator']) && $validated['new_validator'] !== -1) {
            if (Validator::where('rating_id', '=', $validator->rating_id)->where('validator_id', '=', $validated['new_validator'])->exists()) throw new ValidatorAlreadyExistException();
            $this->create($validated['new_validator'], $validator->rating_id);
        }

        if (isset($validated['has_validated'])) {
            if (!(new RatingSkillService())->checkSkills($rating)) throw new NotEnoughSpecificSkillsException();
            if (!(new GoalService())->checkGoals($rating)) throw new NotEnoughGoalsException();
            if ($rating->skills()->where('rating_skill_mark', '=', 0)->exists() || $rating->goals()->where('goal_mark', '=', 0)->exists()) throw new NotRatedCorrectlyException();
            if ($validator->validator_id != $rating->evaluator_id && !$this->checkForEvaluatorValidation($rating)) throw new EvaluatorHasNotValidatedException();
            if ($validator->validator_id != $rating->evaluated_id && $validator->validator_id != $rating->evaluator_id && !$this->checkForEvaluatedValidation($rating)) throw new EvaluatedHasNotValidatedException();
            $validator->update([
                'has_validated' => true,
                'validated_at' => Carbon::now()->toDateTimeString()
            ]);

            if ($this->checkForAllValidation($rating)) {
                $rating->update(['rating_is_validated' => true, 'validated_at' => Carbon::now()->toDateTimeString()]);
                Mail::to($rating->evaluated->email)->queue(new ValidatedRating($rating));
            }
        }

    }

    public function checkForEvaluationPeriods($rating): bool
    {
        $periods = $rating->phase->periods()->get();
        foreach ($periods as $period) {
            if (Carbon::today()->isBetween($period->evaluation_period_start, $period->evaluation_period_end)) return true;
        }
        return false;

    }

    public function checkForAllValidation($rating): bool
    {
        if (Validator::where('rating_id', '=', $rating->rating_id)
            ->where('has_validated', '=', 0)->exists()) return false;
        return true;
    }

    public function checkForEvaluatorValidation($rating): bool
    {

        return Validator::where('rating_id', '=', $rating->rating_id)
            ->where('validator_id', '=', $rating->evaluator_id)
            ->where('has_validated', '=', 1)->exists();
    }

    public function checkForEvaluatedValidation($rating): bool
    {

        return Validator::where('rating_id', '=', $rating->rating_id)
            ->where('validator_id', '=', $rating->evaluated_id)
            ->where('has_validated', '=', 1)->exists();
    }

}
