<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_level_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('name');               // e.g. "Mathematics"
            $table->string('code')->nullable();   // e.g. "MTH-S1"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
