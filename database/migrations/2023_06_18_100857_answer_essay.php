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
        Schema::create('answer_essay', function (Blueprint $table) {
            $table->id('answer_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->cascadeOnDelete();
            $table->foreignId('quiz_id')->constrained('quizzes', 'quiz_id')->cascadeOnDelete();
            $table->foreignId('essay_id')->constrained('essay', 'essay_id')->cascadeOnDelete();
            $table->string('answer', 500)->nullable();
            $table->bigInteger('score')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_essay');
    }
};
