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
            $table->id('user_id');
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->enum('level', ['mahasiswa', 'dosen', 'admin'])->default(null);
            $table->string('nama');
            $table->string('nip')->nullable();
            $table->string('nim')->nullable();
            $table->foreignId('kelas_id')->nullable()->constrained('kelas', 'kelas_id')->nullOnDelete();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('image')->default('default.png');
            $table->string('no_telepon');
            $table->string('provinsi')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('alamat')->nullable();
            $table->foreignId('semester_id')->nullable()->constrained('semester', 'semester_id')->nullOnDelete();
            $table->enum('status', ['terverifikasi', 'belum terverifikasi'])->default('belum terverifikasi');
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
