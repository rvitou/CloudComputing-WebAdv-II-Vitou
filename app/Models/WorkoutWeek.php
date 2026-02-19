<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutWeek extends Model
{
    protected $fillable = [
        'coach_id',
        'student_id',
        'week_start_date',
        'week_end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'week_start_date' => 'date', // Casts to a Carbon date object
        'week_end_date' => 'date',   // Casts to a Carbon date object
    ];

    public function workoutDays()
    {
        return $this->hasMany(WorkoutDay::class, 'week_id');
    }
}
