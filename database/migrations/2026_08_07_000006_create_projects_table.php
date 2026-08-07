<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('project_id');

            // Asumsi: garis relasi Organization -> Project pada ERD menunjukkan
            // FK ini, tapi kolomnya tidak terlihat jelas di gambar (kemungkinan
            // terpotong). Sesuaikan/hapus jika ternyata tidak diperlukan.
            $table->unsignedInteger('organization_id')->nullable();

            $table->string('project_name', 100);
            $table->text('description')->nullable();

            // Asumsi nilai enum status karena tidak tercantum di ERD.
            // Sesuaikan dengan kebutuhan sebenarnya.
            $table->enum('status', ['planning', 'ongoing', 'on_hold', 'completed', 'cancelled'])
                ->default('planning');

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('organization_id')
                ->references('organization_id')->on('organizations')
                ->onDelete('set null');

            $table->foreign('updated_by')
                ->references('user_id')->on('users')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
