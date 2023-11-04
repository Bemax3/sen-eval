<?php

namespace App\Services\Rating;

use App\Models\Rating\RatingSkill;

readonly class RatingSkillService
{
    public function __construct(private RatingService $ratingService){}

    public function update($validated,$id): string
    {
        $ratingSkill = RatingSkill::findOrFail($id);
        if(!$this->ratingService->checkMarking($ratingSkill->rating_id)) return "exceed";
        $this->ratingService->lowerMark($ratingSkill->rating_id,$ratingSkill->rating_skill_mark);
        $ratingSkill->update(['rating_skill_mark' => $validated['rating_skill_mark']]);
        $this->ratingService->raiseMark($ratingSkill->rating_id,$ratingSkill->rating_skill_mark);
        return "ok";
    }

    public function create(mixed $validated): string
    {
        if(!$this->ratingService->checkMarking($validated['rating_id'])) return "exceed";
        if (RatingSkill::where('rating_id','=',$validated['rating_id'])->where('phase_skill_id','=',$validated['phase_skill_id'])->exists()) return "exist";
        RatingSkill::create($validated);
        return "ok";
    }

    public function delete(string $rating_id): void
    {
        $ratingSkill = RatingSkill::with('phaseSkill')->findOrFail($rating_id);
        $this->ratingService->lowerMark($ratingSkill->rating_id,$ratingSkill->rating_skill_mark);
        $ratingSkill->delete();
    }
}
