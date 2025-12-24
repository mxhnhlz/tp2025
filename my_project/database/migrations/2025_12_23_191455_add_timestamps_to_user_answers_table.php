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
        Schema::table('user_answers', function (Blueprint $table) {
            // Добавляем timestamps если их нет
            if (! Schema::hasColumn('user_answers', 'created_at')) {
                $table->timestamps();
            }

            // Убедимся что answered_at существует и имеет дефолтное значение
            if (! Schema::hasColumn('user_answers', 'answered_at')) {
                $table->timestamp('answered_at')->useCurrent();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            //
        });
    }
};
