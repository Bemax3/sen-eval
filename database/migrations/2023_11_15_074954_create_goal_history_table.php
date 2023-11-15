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
        Schema::create('goal_history', function (Blueprint $table) {
            $table->increments('goal_history_id');
            $table->text('comment')->nullable();
            $table->float('goal_rate')->default(0);
            $table->unsignedInteger('goal_id');
            $table->unsignedInteger('updated_by');
            $table->foreign('updated_by')->references('user_id')->on('users');
            $table->foreign('goal_id')->references('goal_id')->on('goals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_history');
    }
};
