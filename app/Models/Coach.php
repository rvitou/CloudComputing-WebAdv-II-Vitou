<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Coach extends Model
{
    protected $fillable = [
        'specialization', 'certification', 'years_of_experience',
        'bio', 'max_students', 'payment_card_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get all of the students for the coach through their subscriptions.
     * This is a "Has Many Through" relationship.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Subscription::class);
    }
}
