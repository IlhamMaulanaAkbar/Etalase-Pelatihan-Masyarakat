<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PostTestQuestions;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PostTestQuestions::class, 'post_test_questions_id')->constrained()->onDelete('cascade');
            $table->string('answer', 255);
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_test_answers');
    }
};
