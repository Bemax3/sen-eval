<?php

namespace App\Services\Evaluation;

use App\Models\Evaluation\EvaluationSkill;

readonly class EvaluationSkillService
{
    public function __construct(private EvaluationService $evaluationService){}

    public function update($validated,$id): string
    {
        $evaluationSkill = EvaluationSkill::findOrFail($id);
        if(!$this->evaluationService->checkMarking($evaluationSkill->evaluation_id)) return "exceed";
        $this->evaluationService->lowerMark($evaluationSkill->evaluation_id,$evaluationSkill->evaluation_skill_mark);
        $evaluationSkill->update([
            'evaluation_skill_mark' => $validated['evaluation_skill_mark']
        ]);
        $this->evaluationService->raiseMark($evaluationSkill->evaluation_id,$evaluationSkill->evaluation_skill_mark);
        return "ok";
    }

    public function create(mixed $validated): string
    {
        if(!$this->evaluationService->checkMarking($validated['evaluation_id'])) return "exceed";
        if (EvaluationSkill::where('evaluation_id','=',$validated['evaluation_id'])->where('phase_skill_id','=',$validated['phase_skill_id'])->exists()) return "exist";
        EvaluationSkill::create($validated);
        return "ok";
    }

    public function delete(string $evaluation_id): void
    {
        $evaluationSkill = EvaluationSkill::with('phaseSkill')->findOrFail($evaluation_id);
        $this->evaluationService->lowerMark($evaluationSkill->evaluation_id,$evaluationSkill->evaluation_skill_mark);
        $evaluationSkill->delete();
    }
}
