<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // We now eager load the user details and all subscriptions,
        // along with the plan and coach for each subscription.
        $students = Student::with([
            'user',
            'subscriptions.plan',
            'subscriptions.coach.user'
        ])->orderBy('id', 'asc')->paginate(15);

        return view('students.index', ['students' => $students]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        // Load the same relationships for the single student view.
        $student->load(['user', 'subscriptions.plan', 'subscriptions.coach.user']);
        
        return view('students.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load('user'); // Edit form only needs basic user and student info

        return view('students.edit', ['student' => $student]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // This validation logic remains the same as it doesn't involve the coach assignment.
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other,prefer_not_to_say',
            'dob' => 'nullable|date',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'experience_level' => 'nullable|string',
            'fitness_goal' => 'nullable|string',
        ]);

        // Update the related User model
        $student->user->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'gender' => $validatedData['gender'],
            'dob' => $validatedData['dob'],
        ]);

        // Update the Student model
        $student->update([
            'height' => $validatedData['height'],
            'weight' => $validatedData['weight'],
            'experience_level' => $validatedData['experience_level'],
            'fitness_goal' => $validatedData['fitness_goal'],
        ]);

        return redirect()->route('students.show', $student)->with('success', 'Student information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Deleting the user will cascade and delete the student, subscriptions etc.
        $student->user->delete();
        
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
