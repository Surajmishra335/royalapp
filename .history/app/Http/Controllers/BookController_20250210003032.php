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
            'description' => 'required|string',
            'isbn' => 'required|string',
            'format' => 'required|string',
            'number_of_pages' => 'required|integer|min:1',
            'author_id' => 'required|integer'
        ]);

        $token = session('api_token');
        $response = Http::withToken($token)->post('https://candidate-testing.api.royal-apps.io/api/v2/books', [
            'author' => ['id' => $request->author_id],
            'title' => $request->title,
            'release_date' => $request->release_date,
            'description' => $request->description,
            'isbn' => $request->isbn,
            'format' => $request->format,
            'number_of_pages' => $request->number_of_pages
        ]);

        dd($response)

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
