<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of authors.
     */
    public function index()
    {
        $token = Session::get('access_token');
        if (!$token) {
            return redirect()->route('auth.login');
        }

        // Fetch authors from API
        $url = "https://candidate-testing.api.royal-apps.io/api/v2/authors";
        $response = Http::withToken($token)->get($url);

        if ($response->successful()) {
            $authors = $response->json()['items']; // Extract only the authors list
            return view('authors.index', compact('authors'));
        }

        return back()->with('error', 'Failed to fetch authors.');
    }

    /**
     * Delete an author if they have no books.
     */
    public function destroy($id)
    {
        $token = Session::get('access_token');
        if (!$token) {
            return redirect()->route('auth.login');
        }

        // Check if the author has books
        $authorUrl = "https://candidate-testing.api.royal-apps.io/api/v2/authors/$id";
        $authorResponse = Http::withToken($token)->get($authorUrl);

        if ($authorResponse->successful()) {
            $authorData = $authorResponse->json();
            dd($$authorData['books']);
            if (!empty($authorData['books'])) {
                return back()->with('error', 'Cannot delete author with books.');
            }
        }

        // Delete author
        $deleteUrl = "https://candidate-testing.api.royal-apps.io/api/v2/authors/$id";
        $deleteResponse = Http::withToken($token)->delete($deleteUrl);

        if ($deleteResponse->successful()) {
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        }

        return back()->with('error', 'Failed to delete author.');
    }

    public function show($id)
    {
        $token = session('access_token'); // Retrieve stored token
        $response = Http::withToken($token)->get("https://candidate-testing.api.royal-apps.io/api/v2/authors/{$id}");

        if ($response->successful()) {
            $author = $response->json();
            return view('authors.show', compact('author'));
        }

        return back()->with('error', 'Failed to fetch author details.');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'biography' => 'required|string',
            'gender' => 'required|in:male,female',
            'place_of_birth' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $token = session('access_token'); // Retrieve the stored token

        $response = Http::withToken($token)->post('https://candidate-testing.api.royal-apps.io/api/v2/authors', [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "birthday" => $request->birthday,
            "biography" => $request->biography,
            "gender" => $request->gender,
            "place_of_birth" => $request->place_of_birth
        ]);

        if ($response->successful()) {
            return response()->json(['message' => 'Author added successfully!']);
        }

        return response()->json(['message' => 'Failed to add author'], 400);
    }

}
