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
        Schema::create('matkul', function (Blueprint $table) {
            $table->id('matkul_id');
            $table->foreignId('dosen_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->string('image');
            $table->string('nama_matkul');
            $table->foreignId('semester_id')->constrained('semester', 'semester_id')->cascadeOnDelete();
            $table->string('deskripsi');
            $table->enum('status', ['aktif', 'nonaktif']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matkul');
    }
};
