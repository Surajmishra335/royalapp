<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', function () {
    if (!session('access_token')) {
        return redirect()->route('auth.login');
    }
    return view('dashboard');
})->name('dashboard');

use App\Http\Controllers\AuthorController;

Route::middleware(['auth.session'])->group(function () {
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
});
