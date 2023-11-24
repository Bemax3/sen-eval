<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\AgentHasRatingForCurrentPhaseException;
use App\Models\Group;
use App\Models\Phase\PhaseSkill;
use App\Models\Rating\Rating;
use App\Models\Rating\RatingSkill;
use App\Models\Settings\SkillType;
use App\Models\User;
use Auth;

class RatingService
{
    public function raiseMark($rating_id, $mark): void
    {
        $eval = Rating::findOrFail($rating_id);
        $eval->increment('rating_mark', $mark);
    }

    public function lowerMark($rating_id, $mark): void
    {
        $eval = Rating::findOrFail($rating_id);
        $eval->decrement('rating_mark', $mark);
    }

    public function checkMarking($rating_id): bool
    {
        $eval = Rating::with('specific_skills')->findOrFail($rating_id);
        $total = 0;
        foreach ($eval->specific_skills as $skill) $total += ($skill->phaseSkill->phase_skill_marking);
        if ($total >= SkillType::SPECIFIC_MARKING) return false;
        return true;
    }

    public function update($data, $rating_id): void
    {
        if (isset($data['remember'])) User::findOrFail(Auth::id())->update(['n1_id' => $data['validator_id']]);
        $rating = Rating::findOrFail($rating_id);
        if (isset($data['rating_is_contested'])) $rating->update(['rating_is_contested' => $data['rating_is_contested'], 'updated_by' => $data['updated_by']]);
    }

    /**
     * @throws AgentHasRatingForCurrentPhaseException
     */
    public function create($validated)
    {
        if (Rating::where('evaluated_id', '=', $validated['evaluated_id'])->where('phase_id', '=', $validated['phase_id'])->exists())
            throw new AgentHasRatingForCurrentPhaseException();
        $rating = Rating::create($validated);
        $user = User::findOrFail($validated['evaluated_id']);
        $operator = $user->isCadre() ? '=' : '!=';
        $skills = PhaseSkill::where('phase_id', '=', $validated['phase_id'])->whereRelation('skill', 'group_id', $operator, Group::CADRE)->get();
        (new ValidatorService())->createMultiple([$validated['evaluated_id'], $validated['evaluator_id']], $rating->rating_id);
        foreach ($skills as $skill)
            $this->createSkills($rating, $skill);
        return $rating;
    }

    private function createSkills(Rating $rating, mixed $skill): void
    {
        RatingSkill::create([
            'rating_id' => $rating->rating_id,
            'phase_skill_id' => $skill->phase_skill_id
        ]);
    }

}
