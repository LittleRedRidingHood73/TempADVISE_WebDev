<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_teams', function (Blueprint $table) {
            $table->increments('project_team_id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('user_id');
            $table->string('project_role', 50)->nullable();
            $table->timestamp('assigned_at')->useCurrent();

            $table->foreign('project_id')
                ->references('project_id')->on('projects')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')->on('users')
                ->onDelete('cascade');

            // * UNIQUE (project_ID, user_ID) sesuai catatan pada ERD
            $table->unique(['project_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_teams');
    }
};
