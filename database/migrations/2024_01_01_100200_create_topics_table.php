<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('title');                          // e.g. "Set Theory"
            $table->text('competency_description')->nullable(); // Learning outcome from syllabus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
