<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    /**
     * Display a listing of all coaches.
     */
    public function index()
    {
        // We load the coach's user details. For the count of students and payout status,
        // we will load the subscriptions and calculate it in the view.
        // This is efficient because it eager loads all necessary data at once.
        $coaches = Coach::with([
            'user',
            'subscriptions.student.user', // Gets the student and their user info for each sub
            'subscriptions.plan'          // Gets the plan details for each sub
        ])->orderBy('id', 'asc')->paginate(15);

        return view('coaches.index', ['coaches' => $coaches]);
    }

    /**
     * Display the specified coach's details page.
     */
    public function show(Coach $coach)
    {
        // Eager load all the relationships we need for the detail view
        $coach->load([
            'user',
            'subscriptions.student.user',
            'subscriptions.plan'
        ]);

        return view('coaches.show', ['coach' => $coach]);
    }

    /**
     * Show the form for editing the specified coach.
     */
    public function edit(Coach $coach)
    {
        $coach->load('user');

        return view('coaches.edit', ['coach' => $coach]);
    }

    /**
     * Update the specified coach's information in the database.
     */
    public function update(Request $request, Coach $coach)
    {
        // This validation logic is still correct.
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $coach->user_id,
            'specialization' => 'required|string',
            'certification' => 'required|string',
            'years_of_experience' => 'required|integer|min:0',
            'bio' => 'nullable|string',
        ]);

        // This update logic is also still correct.
        $coach->user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
        ]);

        $coach->update([
            'specialization' => $validatedData['specialization'],
            'certification' => $validatedData['certification'],
            'years_of_experience' => $validatedData['years_of_experience'],
            'bio' => $validatedData['bio'],
        ]);

        return redirect()->route('coaches.show', $coach)->with('success', 'Coach information updated successfully!');
    }

    /**
     * Remove the specified coach from storage.
     */
    public function destroy(Coach $coach)
    {
        // Deleting the user will cascade and delete the coach profile.
        $coach->user->delete();
        
        return redirect()->route('coaches.index')->with('success', 'Coach deleted successfully.');
    }
}
