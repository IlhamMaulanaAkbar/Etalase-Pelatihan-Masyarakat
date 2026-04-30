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
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Training::class, 'training_id')->constrained('trainings')->onDelete('cascade');
            $table->integer('meeting_number');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('material_title');
            $table->text('material_description')->nullable();
            $table->string('speaker_name');
            $table->string('file')->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_schedules');
    }
};
