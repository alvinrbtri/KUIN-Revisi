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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('quiz_id');
            $table->string('quiz_name');
            $table->foreignId('modul_id')->constrained('modul', 'modul_id')->cascadeOnDelete();
            $table->enum('quiz_type', ['Multiple Choice', 'Essay', 'Draggable']);
            $table->date('quiz_date');
            $table->string('jam', 5);
            $table->string('menit', 5);
            $table->string('detik', 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
