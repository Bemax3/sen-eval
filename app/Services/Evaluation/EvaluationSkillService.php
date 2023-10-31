<?php

namespace App\Services\Evaluation;

use App\Models\Evaluation\EvaluationSkill;

class EvaluationSkillService
{
    public function update($validated,$id): void
    {
        $evaluationSkill = EvaluationSkill::with('phaseSkill')->findOrFail($id);
        $evaluationSkill->update([
            'evaluation_skill_mark' => $validated['evaluation_skill_mark']
        ]);
    }
}
