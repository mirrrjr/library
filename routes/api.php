<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

// User
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth:sanctum');
Route::get('users/books/{id}', [UserController::class, 'books'])->name('users.books');

// Book
Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::post('books', [BookController::class, 'store'])->name('books.store')->middleware('auth:sanctum');
Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
Route::put('books/{book}', [BookController::class, 'update'])->name('books.update')->middleware('auth:sanctum');
Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy')->middleware('auth:sanctum');

// Rental
Route::get('rentals', [BookController::class, 'index'])->name('rentals.index');
Route::post('rentals', [BookController::class, 'store'])->name('rentals.store')->middleware('auth:sanctum');
Route::get('rentals/{rental}', [BookController::class, 'show'])->name('rentals.show');
Route::put('rentals/{rental}', [BookController::class, 'update'])->name('rentals.update')->middleware('auth:sanctum');
Route::delete('rentals/{rental}', [BookController::class, 'destroy'])->name('rentals.destroy')->middleware('auth:sanctum');
