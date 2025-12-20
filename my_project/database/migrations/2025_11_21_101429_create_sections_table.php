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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); //название раздела
            $table->text('description')->nullable();
            $table->timestamps();
            $table->string('color')->default('from-blue-500 to-cyan-500');
            $table->string('icon')->default('Lock');
            $table->boolean('is_locked')->default(false);
            $table->integer('order')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
