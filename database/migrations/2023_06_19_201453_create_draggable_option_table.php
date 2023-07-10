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
        Schema::create('draggable_option', function (Blueprint $table) {
            $table->id('draggable_opt_id');
            $table->foreignId('quiz_id')->constrained('quizzes', 'quiz_id')->cascadeOnDelete();
            $table->foreignId('draggable_id')->nullable()->constrained('draggable', 'draggable_id')->nullOnDelete();
            $table->string('draggable_answer', 500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draggable_option');
    }
};
