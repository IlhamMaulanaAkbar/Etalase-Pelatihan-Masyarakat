<?php

use App\Models\Assistance;
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
        Schema::dropIfExists('lessons_assistance');

        Schema::create('assistance_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Assistance::class, 'assistance_id')->constrained('assistance')->onDelete('cascade');
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

        Schema::create('assistance_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_id')->constrained('assistance')->onDelete('cascade');
            $table->foreignId('assistance_schedule_id')->constrained('assistance_schedules')->onDelete('cascade');
            $table->string('participant_name');
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'])->default('Hadir');
            $table->time('attendance_time')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_attendances');
        Schema::dropIfExists('assistance_schedules');
    }
};
