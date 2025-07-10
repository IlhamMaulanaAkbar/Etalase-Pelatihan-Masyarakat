<?php

use App\Models\TrainingEvaluationQuestions;
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
        Schema::create('training_evaluation_users_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TrainingEvaluationQuestions::class, 'teq_id')->constrained('training_evaluation_questions')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'users_id')->constrained()->onDelete('cascade');
            $table->text('answers');
            $table->timestamps();

            $table->unique(['teq_id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_evaluation_users_answers');
    }
};
