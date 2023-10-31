<?php

namespace App\Services\Evaluation;

use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\EvaluationSkill;
use App\Models\Group;
use App\Models\Phase\PhaseSkill;
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

}
