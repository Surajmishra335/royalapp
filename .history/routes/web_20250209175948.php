<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthSession;
use App\Http\Controllers\AuthorController;


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

Route::middleware(AuthSession::class)->group(function () {
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');

});
