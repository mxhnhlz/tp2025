<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table
                ->foreignId('option_id')
                ->nullable()
                ->constrained('question_options')
                ->nullOnDelete();
            $table->text('text_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamp('answered_at')->useCurrent();

            $table->index(['user_id', 'question_id']);
            $table->index('question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_answers');
    }
};
