<?php

namespace App\Services\Evaluation;

use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\EvaluationSkill;
use App\Models\Group;
use App\Models\Phase\PhaseSkill;
use App\Models\Settings\SkillType;
use App\Models\User;

class EvaluationService
{
    public function create($validated) {
        $evaluation = Evaluation::create($validated);

        $user = User::findOrFail($validated['evaluated_id']);

        $operator = $user->isCadre() ? '=' : '!=';
        $skills = PhaseSkill::where('phase_id','=',$validated['phase_id'])->whereRelation('skill','group_id',$operator,Group::CADRE)->get();
        foreach ($skills as $skill)
            $this->createSkills($evaluation,$skill);

        return $evaluation;
    }

    private function createSkills(Evaluation $evaluation, mixed $skill): void
    {
        EvaluationSkill::create([
            'evaluation_id' => $evaluation->evaluation_id,
            'phase_skill_id' => $skill->phase_skill_id
        ]);
    }

    public function raiseMark($evaluation_id,$mark): void
    {
        $eval = Evaluation::findOrFail($evaluation_id);
        $eval->increment('evaluation_mark', $mark);
    }
    public function lowerMark($evaluation_id,$mark): void
    {
        $eval = Evaluation::findOrFail($evaluation_id);
        $eval->decrement('evaluation_mark',$mark);
    }

    public function checkMarking($evaluation_id): bool
    {
        $eval = Evaluation::with('specific_skills')->findOrFail($evaluation_id);
        $total = 0;
        foreach ($eval->specific_skills as $skill) $total += ($skill->phaseSkill->phase_skill_marking);
        if($total >= SkillType::SPECIFIC_MARKING) return false;
        return true;
    }

}
