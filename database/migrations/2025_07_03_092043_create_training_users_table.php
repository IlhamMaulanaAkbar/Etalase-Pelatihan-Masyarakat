<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Training;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(Training::class, 'training_id')->constrained('trainings')->onDelete('cascade');
            $table->string('registration_number')->unique()->nullable();
            // Status partisipasi
            $table->enum('status', ['DAFTAR', 'LULUS', 'TIDAK_LULUS', 'BATAL'])->default('DAFTAR');
            $table->boolean('is_approved')->default(false);
            $table->string('letter_recommendation')->nullable();
            $table->string('letter_statement')->nullable();
            $table->boolean('started_pretest')->default(false);
            $table->boolean('started_posttest')->default(false);
            $table->boolean('started_training_evaluation')->default(false);
            $table->boolean('started_instructor_evaluation')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_users');
    }
};
