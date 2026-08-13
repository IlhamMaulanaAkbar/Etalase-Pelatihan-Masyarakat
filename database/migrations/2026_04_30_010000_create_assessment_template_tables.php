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
        Schema::dropIfExists('assessment_template_answers');
        Schema::dropIfExists('assessment_template_questions');

        Schema::create('assessment_template_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('category')->onDelete('cascade');
            $table->enum('template_type', [
                'pre_test',
                'post_test',
                'training_evaluation',
                'instructor_evaluation',
            ]);
            $table->string('question', 255);
            $table->enum('question_type', ['scale', 'text'])->nullable();
            $table->timestamps();
        });

        Schema::create('assessment_template_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assessment_template_question_id');
            $table->string('answer', 255);
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->foreign('assessment_template_question_id', 'assessment_template_answers_question_fk')
                ->references('id')
                ->on('assessment_template_questions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_template_answers');
        Schema::dropIfExists('assessment_template_questions');
    }
};
