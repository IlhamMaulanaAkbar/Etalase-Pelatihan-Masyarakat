<?php

use App\Models\Training;
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
        Schema::create('training_evaluation_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class,'training_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('training_evaluation_questions');
    }
};
