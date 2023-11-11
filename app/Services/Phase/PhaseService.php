<?php

namespace App\Services\Phase;

use App\Exceptions\Phase\PhaseAlreadyExistException;
use App\Models\Phase\Phase;
use App\Models\Settings\PeriodType;
use App\Models\Settings\Skill;
use Carbon\Carbon;

class PhaseService
{
    /**
     * @throws PhaseAlreadyExistException
     */
    public function create(mixed $validated): void
    {
        if (Phase::where('phase_year', '=', $validated['phase_year'])->exists()) throw new PhaseAlreadyExistException();
        $phase = Phase::create($validated);
        $this->generatePeriods($phase);
        $this->generateSkills($phase);
    }

    public function generatePeriods(Phase $phase): void
    {
        switch ($phase->period_type_id) {
            case PeriodType::SEMIYEARLY:
                for ($i = (12 / 2); $i <= 12; $i = $i + (12 / 2)) {
                    $start_date = Carbon::createFromDate($phase->phase_year, $i)->startOfMonth()->toDateTimeString();
                    $end_date = Carbon::createFromDate($phase->phase_year, $i)->endOfMonth()->addDays(5)->toDateTimeString();
                    $phase->periods()->create([
                        'evaluation_period_name' => 'Semestre ' . $i / 6,
                        'evaluation_period_start' => $start_date,
                        'evaluation_period_end' => $end_date
                    ]);
                }
                break;
            case PeriodType::TRIMONTHLY:
                for ($i = (12 / 4); $i <= 12; $i = $i + (12 / 4)) {
                    $start_date = Carbon::createFromDate($phase->phase_year, $i)->startOfMonth()->toDateTimeString();
                    $end_date = Carbon::createFromDate($phase->phase_year, $i)->endOfMonth()->addDays(5)->toDateTimeString();
                    $phase->periods()->create([
                        'evaluation_period_name' => 'Trimestre ' . $i / 3,
                        'evaluation_period_start' => $start_date,
                        'evaluation_period_end' => $end_date
                    ]);
                }
                break;
            case PeriodType::MONTHLY:
                for ($i = 1; $i <= 12; $i = $i + 1) {
                    $start_date = Carbon::createFromDate($phase->phase_year, $i)->startOfMonth();
                    $end_date = Carbon::createFromDate($phase->phase_year, $i)->endOfMonth()->addDays(5)->toDateTimeString();
                    $phase->periods()->create([
                        'evaluation_period_name' => 'Mois de ' . $start_date->locale('fr')->monthName,
                        'evaluation_period_start' => $start_date->toDateTimeString(),
                        'evaluation_period_end' => $end_date
                    ]);
                }
                break;
            default:
                break;
        }
    }

    public function generateSkills(Phase $phase): void
    {
        $skills = Skill::where('skill_is_active', '=', 1)->select(['skill_id', 'skill_marking'])->get();
        foreach ($skills as $skill) {
            $phase->skills()->attach($skill->skill_id, ['phase_skill_marking' => $skill->skill_marking]);
        }
    }

    public function destroy(int $id): void
    {
        Phase::findOrFail($id)->delete();
    }

    public function updateStatus(int $id, mixed $validated): void
    {
        $phase = Phase::findOrFail($id);
        $phase->update($validated);
    }

    /**
     * @throws PhaseAlreadyExistException
     */
    public function update(string $id, mixed $validated): void
    {
        $phase = Phase::findOrFail($id);
        if ($validated['phase_year'] != $phase->phase_year && Phase::where('phase_year', '=', $validated['phase_year'])->exists())
            throw new PhaseAlreadyExistException();
        $phase->update($validated);
        if ($phase->period_type_id != $validated['period_type_id']) {
            foreach ($phase->periods()->get() as $period) {
                $period->delete();
            }
            $this->generatePeriods($phase);
        }
    }
}
