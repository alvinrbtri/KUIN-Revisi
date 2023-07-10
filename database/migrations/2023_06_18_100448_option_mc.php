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
        Schema::create('option_mc', function (Blueprint $table) {
            $table->id('option_id');
            $table->foreignId('question_id')->constrained('question_mc', 'question_id')->cascadeOnDelete();
            $table->string('opsi1', 500);
            $table->string('opsi2', 500);
            $table->string('opsi3', 500);
            $table->string('opsi4', 500);
            $table->string('opsi5', 500);
            $table->string('key_answer', 500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_mc');
    }
};
