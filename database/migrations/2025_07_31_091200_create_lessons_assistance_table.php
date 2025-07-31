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
        Schema::create('lessons_assistance', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Assistance::class, 'assistance_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('file', 255);
            $table->string('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons_assistance');
    }
};
