<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // API Login Endpoint
        $url = "https://candidate-testing.com/api/v2/token";

        // Make API request
        $response = Http::post($url, [
            'email' => $request->email,
            'password' => $request->password
        ]);
        Log::
        // Check if login is successful
        if ($response->successful()) {
            $data = $response->json();
            $token = $data['token'];

            // Store token in session
            Session::put('access_token', $token);
            Session::put('user', $data['user']); // Store user details

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout()
    {
        // Clear session
        Session::forget('access_token');
        Session::forget('user');

        return redirect()->route('auth.login');
    }
}
