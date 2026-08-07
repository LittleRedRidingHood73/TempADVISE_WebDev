<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel "User Role" pada ERD -> menyimpan histori/penugasan role ke user,
        // terpisah dari users.role_id yang menyimpan role aktif saat ini.
        Schema::create('user_roles', function (Blueprint $table) {
            $table->increments('userrole_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id');
            $table->timestamp('assigned_at')->useCurrent();

            $table->foreign('role_id')
                ->references('role_id')->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('user_id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
