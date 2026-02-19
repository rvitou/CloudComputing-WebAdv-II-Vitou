<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'coach_id', 'height', 'weight',
        'experience_level', 'fitness_goal',
        'dob', 'gender',
        'payment_card_number', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the student's currently active subscription.
     */
    public function activeSubscription()
    {
        return $this->subscriptions()->where('is_active', true)->latest('start_date')->first();
    }

    /**
     * Get the coach for the student's current active subscription.
     * This is an accessor, not a direct relationship.
     */
    public function getCurrentCoachAttribute()
    {
        $activeSub = $this->activeSubscription();
        return $activeSub ? $activeSub->coach : null;
    }

    public function workoutWeeks()
    {
        return $this->hasMany(WorkoutWeek::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
