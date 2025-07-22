<?php

use App\Models\InstructorEvaluationQuestions;
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
        Schema::create('instructor_evaluation_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InstructorEvaluationQuestions::class, 'ieq_id')->constrained('instructor_evaluation_questions')->onDelete('cascade');
            $table->string('answers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_evaluation_answers');
    }
};
