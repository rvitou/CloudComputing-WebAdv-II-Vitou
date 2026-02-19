<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'coach_id',
        'start_time',
        'end_time',
        'join_url',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'string', // 'scheduled', 'ongoing', 'completed', 'cancelled'
    ];

    /**
     * Get the coach that owns the LiveSession.
     */
    public function coach()
    {
        return $this->belongsTo(Coach::class);
    }
}

