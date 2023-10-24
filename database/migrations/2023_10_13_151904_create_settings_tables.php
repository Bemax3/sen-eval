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
        Schema::create('mobility_types', function (Blueprint $table) {
            $table->increments('mobility_type_id');
            $table->string('mobility_type_name');
            $table->string('mobility_type_desc')->nullable();
            $table->boolean('mobility_type_is_active')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('training_types', function (Blueprint $table) {
            $table->increments('training_type_id');
            $table->string('training_type_name');
            $table->string('training_type_desc')->nullable();
            $table->boolean('training_type_is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sanction_types', function (Blueprint $table) {
            $table->increments('sanction_type_id');
            $table->string('sanction_type_name');
            $table->string('sanction_type_desc')->nullable();
            $table->boolean('sanction_type_is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('claim_types', function (Blueprint $table) {
            $table->increments('claim_type_id');
            $table->string('claim_type_name');
            $table->string('claim_type_desc')->nullable();
            $table->boolean('claim_type_is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('skill_types', function (Blueprint $table) {
            $table->increments('skill_type_id');
            $table->string('skill_type_name');
            $table->integer('skill_type_marking');
            $table->string('skill_type_desc')->nullable();
//            $table->boolean('claim_type_is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->increments('skill_id');
            $table->string('skill_name');
            $table->string('skill_desc')->nullable();
            $table->integer('skill_marking');
            $table->boolean('skill_is_active')->default(true);
            $table->unsignedInteger('skill_type_id');
            $table->foreign('skill_type_id')->references('skill_type_id')->on('skill_types');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('period_types',function (Blueprint $table) {
            $table->increments('period_type_id');
            $table->string('period_type_name');
            $table->string('period_type_code');
            $table->string('period_type_desc')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobility_types');
        Schema::dropIfExists('training_types');
        Schema::dropIfExists('sanction_types');
        Schema::dropIfExists('claim_types');
        Schema::dropIfExists('skill_types');
        Schema::dropIfExists('skills');
    }
};
