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
            $table->timestamps();
        });

        Schema::create('training_types', function (Blueprint $table) {
            $table->increments('training_type_id');
            $table->string('training_type_name');
            $table->string('training_type_desc')->nullable();
            $table->timestamps();
        });

        Schema::create('sanction_types', function (Blueprint $table) {
            $table->increments('sanction_type_id');
            $table->string('sanction_type_name');
            $table->string('sanction_type_desc')->nullable();
            $table->timestamps();
        });

        Schema::create('claim_types', function (Blueprint $table) {
            $table->increments('claim_type_id');
            $table->string('claim_type_name');
            $table->string('claim_type_desc')->nullable();
            $table->timestamps();
        });

        Schema::create('skill_types', function (Blueprint $table) {
            $table->increments('skill_type_id');
            $table->string('skill_type_name');
            $table->string('skill_type_desc')->nullable();
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
    }
};
