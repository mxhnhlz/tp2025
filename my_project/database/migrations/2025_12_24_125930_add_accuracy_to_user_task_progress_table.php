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
        Schema::table('user_task_progress', function (Blueprint $table) {
            $table->decimal('accuracy', 5, 2)->default(0); // точность в процентах, например 85.50%
        });
    }

    public function down(): void
    {
        Schema::table('user_task_progress', function (Blueprint $table) {
            $table->dropColumn('accuracy');
        });
    }

};
