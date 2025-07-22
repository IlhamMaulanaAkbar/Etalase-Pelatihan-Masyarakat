<?php

use App\Models\InstructorEvaluationQuestions;
use App\Models\User;
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
        Schema::create('instructor_evaluation_users_answers', function (Blueprint $table) {
                        $table->id();
            $table->foreignIdFor(InstructorEvaluationQuestions::class, 'ieq_id')->constrained('instructor_evaluation_questions')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'users_id')->constrained()->onDelete('cascade');
            $table->text('answers');
            $table->timestamps();

            $table->unique(['ieq_id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructor_evaluation_users_answers');
    }
};
