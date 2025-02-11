@extends('layouts.app')

@section('title', 'Books lis')
@section('content')
    <h1>Books List</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Release Date</th>
                <th>ISBN</th>
                <th>FORMAT</th>
                <th>PAGES</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book['id'] }}</td>
                    <td>{{ $book['title'] }}</td>
                    <td>{{ $book['release_date'] }}</td>
                    <td>{{ $book['isbn'] }}</td>
                    <td>{{ $book['format'] }}</td>
                    <td>{{ $book['number_of_pages'] }}</td>
                    <td>
                        <form action="{{ route('books.destroy', $book['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
@endsection
