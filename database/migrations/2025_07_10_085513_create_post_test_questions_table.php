<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Training;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class, 'training_id')->constrained()->onDelete('cascade');
            $table->string('question', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_test_questions');
    }
};
