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
        Schema::create('phase_skills', function (Blueprint $table) {
            $table->increments('phase_skill_id');
            $table->unsignedInteger('phase_id');
            $table->unsignedInteger('skill_id');
            $table->integer('phase_skill_marking');
            $table->boolean('phase_skill_is_active')->default(true);
            $table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->foreign('skill_id')->references('skill_id')->on('skills');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phase_skills');
    }
};
