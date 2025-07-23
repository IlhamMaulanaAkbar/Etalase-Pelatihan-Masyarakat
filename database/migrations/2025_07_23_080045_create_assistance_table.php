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
        Schema::create('assistance', function (Blueprint $table) {
            $table->id();
            $table->string('assistance_name', 128);
            $table->foreignIdFor(Training::class, 'training_id')->nullable()
                ->constrained('trainings')
                ->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->date('deadline_date');
            $table->string('location', 255);
            $table->enum('status', ['BUKA', 'TUTUP', 'SELESAI']);
            $table->string('thumbnail_image', 255);
            $table->text('description');
            $table->text('target_audience');
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance');
    }
};
