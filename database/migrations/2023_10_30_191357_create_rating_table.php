<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('rating_id');
            $table->unsignedInteger('evaluator_id');
            $table->unsignedInteger('evaluated_id');
//            $table->unsignedInteger('validator_id')->nullable();
//            $table->boolean('validated_by_evaluated')->default(false);
//            $table->boolean('validated_by_n1')->default(false);
//            $table->boolean('validated_by_n2')->default(false);
            $table->boolean('rating_is_contested')->default(false);
            $table->unsignedInteger('phase_id');
            $table->float('rating_mark')->default(0);
//            $table->string('evaluator_comment')->nullable();
//            $table->string('evaluated_comment')->nullable();
            $table->foreign('evaluator_id')->references('user_id')->on('users');
            $table->foreign('evaluated_id')->references('user_id')->on('users');
//            $table->foreign('validator_id')->references('user_id')->on('users');
            $table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->timestamps();
        });

        Schema::create('rating_validators', function (Blueprint $table) {
            $table->increments('rating_validator_id');
            $table->longText('rating_validator_comment')->nullable();
            $table->boolean('has_validated')->default(false);
            $table->dateTime('validated_at')->nullable();
            $table->unsignedInteger('validator_id');
            $table->unsignedInteger('rating_id');
            $table->foreign('validator_id')->references('user_id')->on('users');
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->timestamps();
        });

        Schema::create('rating_skills', function (Blueprint $table) {
            $table->increments('rating_skill_id');
            $table->text('rating_skill_name')->nullable();
            $table->float('rating_skill_mark')->default(0);
            $table->boolean('rating_skill_mark_is_claimed')->default(false);
            $table->unsignedInteger('phase_skill_id');
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('phase_skill_id')->references('phase_skill_id')->on('phase_skills');
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->timestamps();
        });

        Schema::create('rating_trainings', function (Blueprint $table) {
            $table->increments('rating_training_id');
            $table->boolean('asked_by_evaluated')->nullable();
            $table->boolean('asked_by_evaluator')->nullable();
            $table->longText('evaluator_comment')->nullable();
            $table->longText('evaluated_comment')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('training_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->foreign('training_type_id')->references('training_type_id')->on('training_types');
            $table->timestamps();
        });

        Schema::create('rating_mobilities', function (Blueprint $table) {
            $table->increments('rating_mobility_id');
            $table->string('rating_mobility_title')->nullable();
            $table->longText('rating_mobility_comment')->nullable();
            $table->unsignedInteger('asked_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('mobility_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('asked_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->foreign('mobility_type_id')->references('mobility_type_id')->on('mobility_types');
            $table->timestamps();
        });

        Schema::create('rating_sanctions', function (Blueprint $table) {
            $table->increments('rating_sanction_id');
            $table->longText('rating_sanction_comment')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('sanction_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->foreign('sanction_type_id')->references('sanction_type_id')->on('sanction_types');
            $table->timestamps();
        });

        Schema::create('rating_claims', function (Blueprint $table) {
            $table->increments('rating_claim_id');
            $table->longText('rating_claim_comment')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('claim_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->foreign('claim_type_id')->references('claim_type_id')->on('claim_types');
            $table->timestamps();
        });

        Schema::create('rating_promotions', function (Blueprint $table) {
            $table->increments('rating_promotion_id');
            $table->boolean('evaluated_is_eligible')->default(false);
            $table->longText('rating_promotion_comment')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('rating_id');
            $table->unsignedInteger('promotion_type_id');
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
            $table->foreign('rating_id')->references('rating_id')->on('ratings');
            $table->foreign('promotion_type_id')->references('promotion_type_id')->on('promotion_types');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};
