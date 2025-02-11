<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Assuming the user data is stored in session
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your profile.');
        }

        return view('profile', compact('user'));
    }
}
