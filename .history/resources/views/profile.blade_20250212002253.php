@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">User Profile</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ $user['first_name'] }}+{{ $user['last_name'] }}" 
                             class="rounded-circle" width="100" height="100">
                        <h5 class="mt-2">{{ $user['first_name'] }} {{ $user['last_name'] }}</h5>
                        <span class="badge bg-success">{{ $user['active'] ? 'Active' : 'Inactive' }}</span>
                    </div>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user['email'] }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ ucfirst($user['gender']) }}</td>
                            </tr>
                            <tr>
                                <th>Email Confirmed</th>
                                <td>{{ $user['email_confirmed'] ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ \Carbon\Carbon::parse($user['created_at'])->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ \Carbon\Carbon::parse($user['updated_at'])->format('M d, Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <a href="{{ url('/') }}" class="btn btn-secondary">Back to Home</a>
                        <a href="#" class="btn btn-danger">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
