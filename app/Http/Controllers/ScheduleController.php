<?php

namespace App\Http\Controllers;

use App\Models\LiveSession;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the live sessions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all live sessions, eager-loading the 'coach' relationship.
        // We also eager-load the 'user' relationship nested within 'coach'
        // to access the coach's first name.
        // Order by start_time to show upcoming sessions first.
        $liveSessions = LiveSession::with(['coach.user'])
                                   ->orderBy('id', 'asc')
                                   ->get();

        // Count the number of scheduled or upcoming meetings
        // You might want to refine this count based on specific criteria,
        // e.g., only sessions that are 'scheduled' and in the future.
        $scheduledMeetingsCount = $liveSessions->where('status', 'scheduled')->count();

        return view('schedules', compact('liveSessions', 'scheduledMeetingsCount'));
    }
}

