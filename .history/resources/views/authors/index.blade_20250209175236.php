<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Authors List</h1> <button c></button>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Gender</th>
                <th>Place of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author['id'] }}</td>
                    <td>{{ $author['first_name'] }} {{ $author['last_name'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($author['birthday'])->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($author['gender']) }}</td>
                    <td>{{ $author['place_of_birth'] }}</td>
                    <td>
                        <a href="{{ route('authors.show', $author['id']) }}" class="btn btn-info">View Details</a>

                        {{-- Assuming books API, replace "0" with actual book count --}}
                        @if (0 == 0) 
                            <form action="{{ route('authors.destroy', $author['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @else
                            <button class="btn btn-secondary" disabled>Cannot Delete</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
</body>
</html>
