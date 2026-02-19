<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of all exercises.
     */
    public function index()
    {
        $exercises = Exercise::with('coach.user')->latest()->paginate(9);
        return view('exercises.index', ['exercises' => $exercises]);
    }

    /**
     * Display the specified exercise's details.
     */
    public function show(Exercise $exercise)
    {
        $exercise->load('coach.user');
        return view('exercises.show', ['exercise' => $exercise]);
    }

    /**
     * Remove the specified exercise from the database.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }
}
