<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutDay extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'week_id',
        'day_number',
        'day_name',
        'start_time',
        'finish_time',
        'notes',
    ];
    /**
     * Define the relationship: A WorkoutDay belongs to a WorkoutWeek.
     */
    public function workoutWeek()
    {
        return $this->belongsTo(WorkoutWeek::class, 'week_id');
    }

    /**
     * Define the relationship: A WorkoutDay has many PlannedExercises.
     */
    public function plannedExercises()
    {
        return $this->hasMany(PlannedExercise::class);
    }
}
