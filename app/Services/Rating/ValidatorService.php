<?php

namespace App\Services\Rating;

use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\Rating\EvaluatedHasNotValidatedException;
use App\Exceptions\Rating\NotEnoughSpecificSkillsException;
use App\Exceptions\Rating\NotRatedCorrectlyException;
use App\Exceptions\Rating\ValidatorAlreadyExistException;
use App\Models\Rating\Rating;
use App\Models\Rating\Validator;
use App\Models\User;
use Carbon\Carbon;

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
     */
    public function update(string $validation, mixed $validated): void
    {
        $validator = Validator::findOrFail($validation);

        if (isset($validated['remember']) && $validated['remember']) User::findOrFail(\Auth::id())->update(['n1_id' => $validated['new_validator']]);

        if (isset($validated['rating_validator_comment']))
            $validator->update([
                'rating_validator_comment' => $validated['rating_validator_comment']
            ]);

        if (isset($validated['new_validator'])) {
            if (Validator::where('rating_id', '=', $validator->rating_id)->where('validator_id', '=', $validated['new_validator'])->exists()) throw new ValidatorAlreadyExistException();
            $this->create($validated['new_validator'], $validator->rating_id);
        }

        if (isset($validated['has_validated'])) {
            $rating = Rating::findOrFail($validator->rating_id);
            if (!(new RatingSkillService())->checkSkills($rating)) throw new NotEnoughSpecificSkillsException();
            if (!(new GoalService())->checkGoals($rating)) throw new NotEnoughGoalsException();
            if ($rating->skills()->where('rating_skill_mark', '=', 0)->exists() || $rating->goals()->where('goal_mark', '=', 0)->exists()) throw new NotRatedCorrectlyException();
            if ($validator->validator_id != $rating->evaluated_id && $validator->validator_id != $rating->evaluator_id && !$this->checkForEvaluatedValidation($rating)) throw new EvaluatedHasNotValidatedException();
            $validator->update([
                'has_validated' => true,
                'validated_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }

    public function checkForEvaluatedValidation($rating): bool
    {
        if (Validator::where('rating_id', '=', $rating->rating_id)
            ->where('validator_id', '=', $rating->evaluated_id)
            ->where('has_validated', '=', 1)->exists()) return true;

        return false;
    }


}
