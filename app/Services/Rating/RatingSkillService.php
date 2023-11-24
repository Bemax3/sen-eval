<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\DefaultSkillNeedsANameException;
use App\Exceptions\Rating\SkillAlreadyExistException;
use App\Exceptions\Rating\SkillsExceedsMarkingException;
use App\Exceptions\UnauthorizedActionException;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingSkill;
use App\Models\Settings\SkillType;

readonly class RatingSkillService
{
    public function __construct(private RatingService $ratingService = new RatingService())
    {
    }

    /**
     * @throws UnauthorizedActionException
     * @throws CantUpdateValidatedRatingException
     */
    public function update($validated, $id): void
    {
        $ratingSkill = RatingSkill::findOrFail($id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($ratingSkill->rating_id))) throw new CantUpdateValidatedRatingException();
        if ($ratingSkill->rating->evaluator_id !== \Auth::id()) throw new UnauthorizedActionException();
//        if(!$this->ratingService->checkMarking($ratingSkill->rating_id)) return "exceed";
        $this->ratingService->lowerMark($ratingSkill->rating_id, $ratingSkill->rating_skill_mark);
        $ratingSkill->update(['rating_skill_mark' => $validated['rating_skill_mark'], 'updated_by' => $validated['updated_by']]);
        $this->ratingService->raiseMark($ratingSkill->rating_id, $ratingSkill->rating_skill_mark);
    }

    /**
     * @throws SkillsExceedsMarkingException
     * @throws SkillAlreadyExistException
     * @throws DefaultSkillNeedsANameException
     * @throws CantUpdateValidatedRatingException
     */
    public function create(mixed $validated): void
    {
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($validated['rating_id']))) throw new CantUpdateValidatedRatingException();
        if (!$this->ratingService->checkMarking($validated['rating_id'])) throw new SkillsExceedsMarkingException();
        if ($validated['phase_skill_id'] !== 1) {
            $validated['rating_skill_name'] = '';
            if (RatingSkill::where('rating_id', '=', $validated['rating_id'])->where('phase_skill_id', '=', $validated['phase_skill_id'])->exists()) throw new SkillAlreadyExistException();
        } else {
            if (!isset($validated['rating_skill_name'])) throw new DefaultSkillNeedsANameException();
            if (RatingSkill::where('rating_id', '=', $validated['rating_id'])->where('rating_skill_name', '=', $validated['rating_skill_name'])->exists()) throw new SkillAlreadyExistException();

        }
        RatingSkill::create($validated);
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function delete(string $rating_id): void
    {
        $ratingSkill = RatingSkill::with('phaseSkill')->findOrFail($rating_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($ratingSkill->rating_id))) throw new CantUpdateValidatedRatingException();
        $this->ratingService->lowerMark($ratingSkill->rating_id, $ratingSkill->rating_skill_mark);
        $ratingSkill->delete();
    }

    public function checkSkills($rating): bool
    {
        if (!$rating->specific_skills()->count()) return false;
        else {
            $skills = $rating->specific_skills()->get();
            $marking = 0;
            foreach ($skills as $skill) {
                $marking += $skill->phaseSkill->phase_skill_marking;
            }
            if ($marking < SkillType::SPECIFIC_MARKING) return false;
        }
        return true;
    }

}
