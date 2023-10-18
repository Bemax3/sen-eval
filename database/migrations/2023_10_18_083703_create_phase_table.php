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
        Schema::create('phases', function (Blueprint $table) {
            $table->increments('phase_id');
            $table->string('phase_name');
            $table->year('phase_year');
            $table->datetime('phase_first_eval_start');
            $table->datetime('phase_first_eval_end');
            $table->datetime('phase_second_eval_start');
            $table->datetime('phase_second_eval_end');
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
