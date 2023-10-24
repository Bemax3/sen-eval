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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_first_name')->nullable();
            $table->string('user_last_name')->nullable();
            $table->string('user_login')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('user_display_name')->nullable();
            $table->string('user_matricule')->unique()->nullable();
            $table->string('user_responsibility_center')->nullable();
            $table->string('user_title')->nullable();
            $table->string('user_gf')->nullable();
            $table->string('user_nr')->nullable();
            $table->string('password')->nullable();
//            $table->binary('user_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('org_id')->nullable();
            $table->unsignedInteger('role_id')->default(\App\Models\Role::USER);
            $table->foreign('group_id')->references('group_id')->on('groups');
            $table->foreign('org_id')->references('org_id')->on('organisations');
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
