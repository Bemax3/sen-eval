<?php

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
        Schema::create('evaluation_periods', function (Blueprint $table) {
            $table->increments('evaluation_period_id');
            $table->datetime('evaluation_period_start');
            $table->datetime('evaluation_period_end');
            $table->unsignedInteger('phase_id');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('phase_id')->references('phase_id')->on('phases')->restrictOnDelete();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_periods');
    }
};
