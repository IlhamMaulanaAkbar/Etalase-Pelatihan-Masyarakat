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
        Schema::table('training_users', function (Blueprint $table) {
            $table->boolean('started_training_evaluation')->default(false)->after('started_posttest');
            $table->boolean('started_instructor_evaluation')->default(false)->after('started_training_evaluation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_users', function (Blueprint $table) {
            //
        });
    }
};
