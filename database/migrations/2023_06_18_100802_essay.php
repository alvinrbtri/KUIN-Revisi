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
        Schema::create('essay', function (Blueprint $table) {
            $table->id('essay_id');
            $table->foreignId('quiz_id')->constrained('quizzes', 'quiz_id')->cascadeOnDelete();
            $table->string('essay_question', 500);
            $table->string('essay_image')->nullable();
            $table->bigInteger('essay_poin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('essay');
    }
};
