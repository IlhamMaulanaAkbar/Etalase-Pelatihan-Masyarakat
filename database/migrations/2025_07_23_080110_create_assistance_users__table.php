<?php

use App\Models\Assistance;
use App\Models\User;
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
        Schema::create('assistance_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(Assistance::class, 'assistance_id')->constrained('assistance')->onDelete('cascade');
            $table->string('registration_number')->unique()->nullable();
            $table->enum('status', ['DAFTAR', 'LULUS', 'TIDAK_LULUS', 'BATAL'])->default('DAFTAR');
            $table->boolean('is_approved')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistance_users_');
    }
};
