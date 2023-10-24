<?php

namespace Database\Seeders\Phase;

use App\Models\Settings\PeriodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periods = [
            [
                'period_type_id' => 1,
                'period_type_name' => 'Semestriel',
                'period_type_code' => 'SEMIYEARLY',

            ],[
                'period_type_id' => 2,
                'period_type_name' => 'Trimestriel',
                'period_type_code' => 'TRIMONTHLY',

            ],[
                'period_type_id' => 3,
                'period_type_name' => 'Mensuel',
                'period_type_code' => 'MONTHLY',
            ],
        ];

        foreach ($periods as $period) {
            PeriodType::create($period);

        }
    }
}
