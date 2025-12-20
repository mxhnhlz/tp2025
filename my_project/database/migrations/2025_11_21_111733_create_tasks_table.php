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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            //связь с разделом
            $table->foreignId('section_id')
                ->constrained('sections')
                ->onDelete('cascade');

            //основа

            $table->string('title');          // Название задания
            $table->string('slug')->unique(); // URL-идентификатор
            $table->text('description')->nullable();

            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('easy');

            $table->integer('points')->default(10);

            $table->integer('order')->default(0);

            $table->timestamps();

            $table->integer('completed')->default(0);
            $table->integer('total')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
