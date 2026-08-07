<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('organization_id');
            $table->string('org_name', 100);

            // Pemilik / pembuat organisasi (relasi ke Users pada ERD)
            $table->unsignedInteger('user_id');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('user_id')
                ->references('user_id')->on('users')
                ->onDelete('restrict');

            $table->foreign('updated_by')
                ->references('user_id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
