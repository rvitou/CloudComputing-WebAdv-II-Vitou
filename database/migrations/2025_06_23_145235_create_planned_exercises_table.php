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
        Schema::create('planned_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_day_id')->constrained('workout_days')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->integer('sets')->default(3);
            $table->integer('reps')->default(10);
            $table->integer('rest_seconds')->default(60);
            $table->integer('order_index')->comment('Used to order exercises within a day');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planned_exercises');
    }
};
