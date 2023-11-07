<?php

namespace App\Services\Rating;

use App\Models\Rating\Rating;
use App\Models\Rating\RatingSkill;
use App\Models\Group;
use App\Models\Phase\PhaseSkill;
use App\Models\Settings\SkillType;
use App\Models\User;

class RatingService
{
    public function create($validated) {

        if(Rating::where('evaluated_id','=',$validated['evaluated_id'])->where('phase_id','=',$validated['phase_id'])->exists())
            return null;

        $rating = Rating::create($validated);

        $user = User::findOrFail($validated['evaluated_id']);

        $operator = $user->isCadre() ? '=' : '!=';

        $skills = PhaseSkill::where('phase_id','=',$validated['phase_id'])->whereRelation('skill','group_id',$operator,Group::CADRE)->get();

        foreach ($skills as $skill)
            $this->createSkills($rating,$skill);

        return $rating;
    }

    private function createSkills(Rating $rating, mixed $skill): void
    {
        RatingSkill::create([
            'rating_id' => $rating->rating_id,
            'phase_skill_id' => $skill->phase_skill_id
        ]);
    }

    public function raiseMark($rating_id,$mark): void
    {
        $eval = Rating::findOrFail($rating_id);
        $eval->increment('rating_mark', $mark);
    }
    public function lowerMark($rating_id,$mark): void
    {
        $eval = Rating::findOrFail($rating_id);
        $eval->decrement('rating_mark',$mark);
    }

    public function checkMarking($rating_id): bool
    {
        $eval = Rating::with('specific_skills')->findOrFail($rating_id);
        $total = 0;
        foreach ($eval->specific_skills as $skill) $total += ($skill->phaseSkill->phase_skill_marking);
        if($total >= SkillType::SPECIFIC_MARKING) return false;
        return true;
    }

    public function update($validated, $rating_id): void
    {
        if(isset($validated['remember'])) User::findOrFail(\Auth::id())->update(['n1_id' => $validated['validator_id']]);
        $rating = Rating::findOrFail($rating_id);
        if(isset($validated['evaluator_comment'])) $rating->update(['evaluator_comment' => $validated['evaluator_comment']]);
        if(isset($validated['evaluated_comment'])) $rating->update(['evaluated_comment' => $validated['evaluated_comment']]);
        if(isset($validated['validator_id'])) $rating->update(['validator_id' => $validated['validator_id']]);
        if(isset($validated['validated_by_n2'])) $rating->update(['validated_by_n2' => $validated['validated_by_n2']]);
        if(isset($validated['validated_by_n1'])) $rating->update(['validated_by_n1' => $validated['validated_by_n1']]);

    }

}
