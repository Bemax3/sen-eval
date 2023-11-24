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
        Schema::table('ratings', function (Blueprint $table) {
            $table->dateTime('validated_at')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('validated_at');
            $table->dropForeign('ratings_updated_by_foreign');
            $table->dropColumn('updated_by');
        });
    }
};
