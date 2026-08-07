<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->unsignedInteger('role_id')->nullable();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password_hash', 255);
            $table->string('full_name', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('role_id')
                ->references('role_id')->on('roles')
                ->onDelete('set null');

            // Self-referencing FK (updated_by menunjuk ke users.user_id sendiri).
            // Ini valid dibuat dalam satu statement CREATE TABLE yang sama.
            $table->foreign('updated_by')
                ->references('user_id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
