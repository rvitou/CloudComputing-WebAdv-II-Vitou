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
        Schema::create('workout_sessions', function (Blueprint $table) {
            $table->id();

            // Foreign key relationships
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('coach_id')->constrained('coaches')->onDelete('cascade');
            $table->foreignId('week_id')->constrained('workout_weeks')->onDelete('cascade');
            $table->foreignId('day_id')->constrained('workout_days')->onDelete('cascade');

            // Session tracking details
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->integer('sets_completed')->nullable();
            $table->integer('reps_completed')->nullable();
            $table->text('feedback')->nullable();
            $table->tinyInteger('rating')->nullable()->comment('1-5 rating from student');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_sessions');
    }
};
