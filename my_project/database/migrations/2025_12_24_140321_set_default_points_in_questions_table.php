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
        // Сначала заменяем все NULL на 10
        \DB::table('questions')->whereNull('points')->update(['points' => 10]);

        // Потом меняем столбец
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('points')->default(10)->change();
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('points')->nullable()->change();
        });
    }

};
