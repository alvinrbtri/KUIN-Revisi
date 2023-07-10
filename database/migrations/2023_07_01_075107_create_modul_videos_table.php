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
        Schema::create('modul_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_id')->nullable()->constrained('modul', 'modul_id')->nullOnDelete();
            $table->string('nama_video');
            $table->string('file_modul')->nullable();
            $table->string('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul__videos');
    }
};
