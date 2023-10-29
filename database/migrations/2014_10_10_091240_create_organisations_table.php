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
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('org_id');
            $table->string('org_name');
            $table->string('org_type')->nullable();
            $table->string('org_responsibility_center')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('org_id')->on('organisations')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
