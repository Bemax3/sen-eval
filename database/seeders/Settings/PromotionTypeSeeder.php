<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\PromotionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotion_types = [
            ['promotion_type_name' => 'Promotion'],
            ['promotion_type_name' => 'Avancement'],
        ];

        foreach ($promotion_types as $promotion_type) {
            PromotionType::create($promotion_type);
        }
    }
}
