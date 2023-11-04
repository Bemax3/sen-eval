<?php

namespace Database\Seeders\Phase;

use App\Models\Phase\Phase;
use App\Models\Settings\PeriodType;
use App\Models\Settings\Skill;
use App\Services\Phase\PhaseService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = [
            [
                'phase_name' => 'Rating de l\'année 2023',
                'phase_year' => 2023,
                'period_type_id' => PeriodType::SEMIYEARLY

            ],[
                'phase_name' => 'Rating de l\'année 2024',
                'phase_year' => 2024,
                'period_type_id' => PeriodType::SEMIYEARLY

            ],[
                'phase_name' => 'Rating de l\'année 2025',
                'phase_year' => 2025,
                'period_type_id' => PeriodType::MONTHLY

            ],[
                'phase_name' => 'Rating de l\'année 2026',
                'phase_year' => 2026,
                'period_type_id' => PeriodType::TRIMONTHLY

            ],
        ];

        foreach ($phases as $phase) {
            $created = Phase::create($phase);
            (new PhaseService)->generateSkills($created);
            (new PhaseService)->generatePeriods($created);
        }
    }
}
