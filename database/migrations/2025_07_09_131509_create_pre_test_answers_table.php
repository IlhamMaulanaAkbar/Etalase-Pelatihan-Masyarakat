<?php

use App\Models\PreTestQuestions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PreTestQuestion;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pre_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PreTestQuestions::class, 'pre_test_questions_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('pre_test_answers');
    }
};
