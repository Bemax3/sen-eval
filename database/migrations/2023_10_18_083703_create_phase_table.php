<?php

use App\Models\Settings\PeriodType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->increments('phase_id');
            $table->string('phase_name');
            $table->year('phase_year');
            $table->unsignedInteger('period_type_id')->default(PeriodType::SEMIYEARLY);
            $table->foreign('period_type_id')->references('period_type_id')->on('period_types');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phases');
    }
};
