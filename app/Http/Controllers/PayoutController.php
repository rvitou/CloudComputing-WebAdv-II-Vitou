<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    /**
     * Mark the specified subscription as paid out to the coach.
     */
    public function store(Subscription $subscription)
    {
        // Set the flag to true and save it to the database
        $subscription->paid_out_to_coach = true;
        $subscription->save();

        // Redirect back to the coach's detail page with a success message
        return back()->with('success', 'Payout processed successfully!');
    }
}