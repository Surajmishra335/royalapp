<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        $token = session('access_token');
        $response = Http::withToken($token)->get('https://candidate-testing.api.royal-apps.io/api/v2/books');

        $books = $response->json()['items'] ?? [];

        return view('books.index', compact('books'));
    }

    public function create()
    {
        $token = session('access_token');
        $response = Http::withToken($token)->get('https://candidate-testing.api.royal-apps.io/api/v2/authors');
        $authors = $response->json()['items'] ?? [];

        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'release_date' => 'required|date',
            'isbn' => 'required|string',
            'author_id' => 'required|integer'
        ]);

        $token = session('access_token');
        $response = Http::withToken($token)->post('https://candidate-testing.api.royal-apps.io/api/v2/books', [
            'title' => $request->title,
            'release_date' => $request->release_date,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id
        ]);

        dd($response);

        if ($response->successful()) {
            return redirect()->route('books.index')->with('success', 'Book added successfully!');
        } else {
            return back()->with('error', 'Failed to add book');
        }
    }

    public function destroy($id)
    {
        $token = session('access_token');
        $response = Http::withToken($token)->delete("https://candidate-testing.api.royal-apps.io/api/v2/books/{$id}");

        if ($response->successful()) {
            return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
        } else {
            return back()->with('error', 'Failed to delete book');
        }
    }
}
