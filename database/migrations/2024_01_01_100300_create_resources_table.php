<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('title');
            $table->enum('resource_type', ['Link', 'PDF', 'Video', 'Simulation'])
                  ->default('Link');
            $table->string('url');
            $table->text('annotation')->nullable();   // Librarian notes / summary
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
