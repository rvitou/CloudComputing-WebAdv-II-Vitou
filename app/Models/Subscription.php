<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'plan_id', 'start_date', 'end_date',
        'is_active', 'auto_renew'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'auto_renew' => 'boolean',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}