@extends('layouts.app')

@section('title', 'Create a new book')
@section('content')
    <h1>Welcome, {{ session('user')['first_name'] ?? 'User' }}!</h1>
    <p>You are logged in.</p>
    <a href="{{ route('auth.logout') }}" class="btn btn-danger">Logout</a>
@
