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
        Schema::table('organisations', function (Blueprint $table) {
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
