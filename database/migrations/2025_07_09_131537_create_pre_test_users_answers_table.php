<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PreTestQuestions;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pre_test_users_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PreTestQuestions::class, 'pre_test_questions_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'users_id')->constrained('users')->onDelete('cascade');
            $table->string('answer', 255);
            $table->timestamps();

            $table->unique(['pre_test_questions_id', 'users_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_test_users_answers');
    }
};
