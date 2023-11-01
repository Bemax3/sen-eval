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
            $table->boolean('goal_mark_is_claimed')->default(false);
            $table->dateTime('goal_expected_date');
            $table->text('goal_expected_result');
            $table->float('goal_rate')->default(0);
            $table->text('goal_evaluated_comment')->nullable();
            $table->text('goal_evaluator_comment')->nullable();
            $table->text('goal_comment')->nullable();
            $table->integer('goal_marking')->default(5);
            $table->float('goal_mark')->default(0);
            $table->unsignedInteger('evaluator_id');
            $table->unsignedInteger('evaluated_id');
            $table->unsignedInteger('phase_id');
            $table->unsignedInteger('evaluation_period_id');
            $table->foreign('evaluator_id')->references('user_id')->on('users');
            $table->foreign('evaluated_id')->references('user_id')->on('users');
            $table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->foreign('evaluation_period_id')->references('evaluation_period_id')->on('evaluation_periods');
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
