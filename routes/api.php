<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

// User
Route::get('users', [UserController::class, 'index'])->name('users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
Route::put('users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth:sanctum');

// Book
Route::get('books', [BookController::class, 'index']);
Route::post('books', [BookController::class, 'store'])->middleware('auth:sanctum');
Route::get('books/{book}', [BookController::class, 'show']);
Route::put('books/{book}', [BookController::class, 'update'])->middleware('auth:sanctum');
Route::delete('books/{book}', [BookController::class, 'destroy'])->middleware('auth:sanctum');
