<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h1>Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h1>

    <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
</body>
</html>
