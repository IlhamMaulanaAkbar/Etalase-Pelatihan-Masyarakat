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
        Schema::create('instructor_evaluation_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class, 'training_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->enum('type', ['scale', 'text']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_evaluation_questions');
    }
};
