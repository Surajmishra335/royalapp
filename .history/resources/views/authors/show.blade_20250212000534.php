<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <h1>Author Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $author['first_name'] }} {{ $author['last_name'] }}</h3>
            <p><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($author['birthday'])->format('Y-m-d') }}</p>
            <p><strong>Biography:</strong> {{ $author['biography'] }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($author['gender']) }}</p>
            <p><strong>Place of Birth:</strong> {{ $author['place_of_birth'] }}</p>
        </div>
    </div>

    <h2 class="mt-4">Books</h2>

    @if (count($author['books']) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Release Date</th>
                    <th>Format</th>
                    <th>Pages</th>
                    <th>ISBN</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($author['books'] as $book)
                    <tr>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($book['release_date'])->format('Y-m-d') }}</td>
                        <td>{{ $book['format'] }}</td>
                        <td>{{ $book['number_of_pages'] }}</td>
                        <td>{{ $book['isbn'] }}</td>
                        <td>{{ $book['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No books found for this author.</p>
    @endif

    <a href="{{ route('authors.index') }}" class="btn btn-primary">Back to Authors</a>
</body>
</html>