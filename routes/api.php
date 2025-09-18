<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/books/{id}', [UserController::class, 'books'])->name('users.books');
    });

    // Book
    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('books.index');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::get('/{book}', [BookController::class, 'show'])->name('books.show');
        Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });

    // Rentals
    Route::prefix('rentals')->group(function () {
        Route::post('rent/{bookId}', [RentalController::class, 'rentBook']);
        Route::post('return/{rentalId}', [RentalController::class, 'returnBook']);
        Route::get('active', [RentalController::class, 'activeRentals']);
        Route::get('overdue', [RentalController::class, 'overdueRentals']);
    });

    // Statistics
    Route::prefix('reports')->group(function () {
        Route::get('/most-read', [ReportController::class, 'mostReadBooks']);
        Route::get('/authors', [ReportController::class, 'authorStatistics']);
        Route::get('/current-rented', [ReportController::class, 'currentRentedCount']);
    });
});
