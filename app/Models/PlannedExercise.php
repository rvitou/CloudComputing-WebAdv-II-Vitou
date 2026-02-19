<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlannedExercise extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'workout_day_id',
        'exercise_id',
        'sets',
        'reps',
        'rest_seconds',
        'order_index',
        'notes',
    ];

    /**
     * Define the relationship: A PlannedExercise belongs to a WorkoutDay.
     */
    public function workoutDay()
    {
        return $this->belongsTo(WorkoutDay::class);
    }

    /**
     * Define the relationship: A PlannedExercise belongs to a single master Exercise.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
