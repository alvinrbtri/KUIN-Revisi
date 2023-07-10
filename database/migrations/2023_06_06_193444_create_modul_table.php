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
        Schema::create('modul', function (Blueprint $table) {
            $table->id('modul_id');
            // $table->foreignId('dosen_id')->nullable()->constrained('users', 'id')->nullOnDelete();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas', 'kelas_id')->nullOnDelete();
            $table->foreignId('matkul_id')->constrained('matkul', 'matkul_id')->cascadeOnDelete();
            // $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('dosen_id')->nullable();
            $table->string('nama_modul');
            $table->string('file_modul');
            $table->text('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};
