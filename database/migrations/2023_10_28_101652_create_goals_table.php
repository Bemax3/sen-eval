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
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('goal_id');
            $table->text('goal_name');
            $table->boolean('goal_means_available');
            $table->boolean('goal_is_accepted')->default(false);
            $table->dateTime('goal_expected_date');
            $table->text('goal_expected_result');
            $table->unsignedInteger('evaluator_id');
            $table->unsignedInteger('evaluated_id');
            $table->unsignedInteger('phase_id');
            $table->foreign('evaluator_id')->references('user_id')->on('users');
            $table->foreign('evaluated_id')->references('user_id')->on('users');
            $table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
