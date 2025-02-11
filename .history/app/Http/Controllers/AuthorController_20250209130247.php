<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
            $authors = $response->json();
            dd($authors);
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
}
