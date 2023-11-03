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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('evaluation_id');
            $table->unsignedInteger('evaluator_id');
            $table->unsignedInteger('evaluated_id');
            $table->unsignedInteger('phase_id');
            $table->float('evaluation_mark')->default(0);
            $table->string('evaluator_comment')->nullable();
            $table->string('evaluated_comment')->nullable();
            $table->foreign('evaluator_id')->references('user_id')->on('users');
            $table->foreign('evaluated_id')->references('user_id')->on('users');
            $table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->timestamps();
        });

        Schema::create('evaluation_skills', function (Blueprint $table) {
            $table->increments('evaluation_skill_id');
            $table->float('evaluation_skill_mark')->default(0);
            $table->boolean('evaluation_skill_mark_is_claimed')->default(false);
            $table->unsignedInteger('phase_skill_id');
            $table->unsignedInteger('evaluation_id');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('phase_skill_id')->references('phase_skill_id')->on('phase_skills');
            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations');
            $table->timestamps();
        });

        Schema::create('evaluation_trainings', function (Blueprint $table) {
            $table->increments('evaluation_training_id');
            $table->boolean('asked_by_evaluated')->nullable();
            $table->boolean('asked_by_evaluator')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('evaluation_id');
            $table->unsignedInteger('training_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations');
            $table->foreign('training_type_id')->references('training_type_id')->on('training_types');
        });
//
//        Schema::create('evaluation_claims', function (Blueprint $table) {
//            $table->increments('evaluation_claim_id');
//            $table->unsignedInteger('evaluation_id');
//            $table->unsignedInteger('updated_by')->nullable();
//            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
//            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations');
//
//        });
//
//        Schema::create('evaluation_mobilities', function (Blueprint $table) {
//            $table->increments('evaluation_mobility_id');
//            $table->unsignedInteger('evaluation_id');
//            $table->unsignedInteger('updated_by')->nullable();
//            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
//            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations');
//
//        });
//
//        Schema::create('evaluation_sanctions', function (Blueprint $table) {
//            $table->increments('evaluation_sanction_id');
//            $table->unsignedInteger('evaluation_id');
//            $table->unsignedInteger('updated_by')->nullable();
//            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
//            $table->foreign('evaluation_id')->references('evaluation_id')->on('evaluations');
//
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};
