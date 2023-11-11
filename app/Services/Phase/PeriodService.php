<?php

namespace App\Services\Phase;

use App\Models\Phase\EvaluationPeriod;
use App\Models\Phase\Phase;
use Carbon\Carbon;

class PeriodService
{
    public function create($validated): void
    {
        $phase = Phase::findOrFail($validated['phase_id']);
        $phase->periods()->create([
            'evaluation_period_start' => Carbon::createFromDate($validated['evaluation_period_start'])->toDateTimeString(),
            'evaluation_period_end' => Carbon::createFromDate($validated['evaluation_period_end'])->toDateTimeString()
        ]);
    }

    public function update(mixed $validated, string $id): void
    {
        $phase = Phase::findOrFail($validated['phase_id']);
        $phase->periods()->findOrFail(intval($id))
            ->update([
                'evaluation_period_start' => Carbon::createFromDate($validated['evaluation_period_start'])->toDateTimeString(),
                'evaluation_period_end' => Carbon::createFromDate($validated['evaluation_period_end'])->toDateTimeString(),
                'updated_by' => $validated['updated_by']
            ]);
    }

    public function delete(string $id): void
    {
        EvaluationPeriod::findOrFail(intval($id))->delete();
    }
}
