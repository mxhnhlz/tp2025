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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('task_id')
                ->constrained('tasks')
                ->cascadeOnDelete();
            $table->text('content');
            $table->enum('type', ['single', 'multiple', 'text']);
            $table->text('hint')->nullable();
            $table->timestamps();
            $table->integer('order')->default(1);
            $table->integer('points')->nullable();

            $table->index('task_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
