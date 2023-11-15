<?php

namespace App\Services\Rating;

use App\Models\Rating\RatingSkill;
use App\Models\Settings\SkillType;

readonly class RatingSkillService
{
    public function __construct(private RatingService $ratingService = new RatingService())
    {
    }

    public function update($validated, $id): string
    {
        $ratingSkill = RatingSkill::findOrFail($id);
        if ($ratingSkill->rating->evaluator_id !== \Auth::id()) return 'revoked';
//        if(!$this->ratingService->checkMarking($ratingSkill->rating_id)) return "exceed";
        $this->ratingService->lowerMark($ratingSkill->rating_id, $ratingSkill->rating_skill_mark);
        $ratingSkill->update(['rating_skill_mark' => $validated['rating_skill_mark']]);
        $this->ratingService->raiseMark($ratingSkill->rating_id, $ratingSkill->rating_skill_mark);
        return "ok";
    }

    public function create(mixed $validated): string
    {
        if (!$this->ratingService->checkMarking($validated['rating_id'])) return "exceed";
//        if (RatingSkill::where('rating_id', '=', $validated['rating_id'])->where('phase_skill_id', '=', $validated['phase_skill_id'])->exists()) return "exist";
        if (RatingSkill::where('rating_id', '=', $validated['rating_id'])->where('rating_skill_name', '=', $validated['rating_skill_name'])->exists()) return "exist";
        RatingSkill::create($validated);
        return "ok";
    }

    public function delete(string $rating_id): void
    {
        $ratingSkill = RatingSkill::with('phaseSkill')->findOrFail($rating_id);
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
