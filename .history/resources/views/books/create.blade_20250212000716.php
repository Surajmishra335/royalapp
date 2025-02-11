@extends('layouts.app')

@section('title', 'C')
@section('content')
    <h1>Add New Book</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="mb-3">
            <label for="release_date" class="form-label">Release Date</label>
            <input type="datetime-local" class="form-control" name="release_date" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>

        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" required>
        </div>

        <div class="mb-3">
            <label for="format" class="form-label">Format</label>
            <input type="text" class="form-control" name="format" required>
        </div>

        <div class="mb-3">
            <label for="number_of_pages" class="form-label">Number of Pages</label>
            <input type="number" class="form-control" name="number_of_pages" required>
        </div>

        <div class="mb-3">
            <label for="author_id" class="form-label">Author</label>
            <select name="author_id" class="form-control" required>
                @foreach ($authors as $author)
                    <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Book</button>
    </form>
@endsection
