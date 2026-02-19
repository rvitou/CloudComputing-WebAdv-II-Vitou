<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin_login'); 
    }

    /**
     * Handle a login request to the application.
     */
    public function login(Request $request)
    {
        // 1. Validate the form data (using the $request object)
        $validatedData = $request->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // 2. Prepare the credentials for the login attempt
        // Note: We use $validatedData to ensure we only use validated input
        $credentials = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'account_type' => 'admin',
        ];

        // 3. Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // If successful, then redirect to the admin dashboard
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // 4. If unsuccessful, then redirect back to the login with an error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not an administrator.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}