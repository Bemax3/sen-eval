<?php

namespace Database\Seeders\Phase;

use App\Models\Phase;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'phase_name' => 'Evaluation de l\'année 2023',
                'phase_year' => '2023',
                'phase_first_eval_start' => Carbon::create(2023,6)->startOfMonth()->toDateTimeString(),
                'phase_first_eval_end' => Carbon::create(2023,7)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_start' => Carbon::create(2023,11)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_end' => Carbon::create(2023,12)->startOfMonth()->toDateTimeString(),
            ],[
                'phase_name' => 'Evaluation de l\'année 2024',
                'phase_year' => '2024',
                'phase_first_eval_start' => Carbon::create(2024,6)->startOfMonth()->toDateTimeString(),
                'phase_first_eval_end' => Carbon::create(2024,7)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_start' => Carbon::create(2024,11)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_end' => Carbon::create(2024,12)->startOfMonth()->toDateTimeString(),
            ],[
                'phase_name' => 'Evaluation de l\'année 2025',
                'phase_year' => '2025',
                'phase_first_eval_start' => Carbon::create(2025,6)->startOfMonth()->toDateTimeString(),
                'phase_first_eval_end' => Carbon::create(2025,7)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_start' => Carbon::create(2025,11)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_end' => Carbon::create(2025,12)->startOfMonth()->toDateTimeString(),
            ],[
                'phase_name' => 'Evaluation de l\'année 2026',
                'phase_year' => '2026',
                'phase_first_eval_start' => Carbon::create(2026,6)->startOfMonth()->toDateTimeString(),
                'phase_first_eval_end' => Carbon::create(2026,7)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_start' => Carbon::create(2026,11)->startOfMonth()->toDateTimeString(),
                'phase_second_eval_end' => Carbon::create(2026,12)->startOfMonth()->toDateTimeString(),
            ],
        ];

        foreach ($phases as $phase) {
            Phase::create($phase);
        }
    }
}
