<?php

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
        Schema::create('workout_days', function (Blueprint $table) {
            $table->id();
            // onDelete('cascade') means if a workout_week is deleted, all its days are also deleted.
            $table->foreignId('week_id')->constrained('workout_weeks')->onDelete('cascade');
            $table->tinyInteger('day_number'); // e.g., 1 for Monday, 2 for Tuesday
            $table->string('day_name');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('finish_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_days');
    }
};
