<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookService
{
    public function getAllBooksQuery()
    {
        return Book::paginate(10);
    }

    public function getBookById(int $id): ?Book
    {
        return Book::find($id);
    }

    public function createBook(array $data): Book
    {
        try {
            Gate::authorize('create', Book::class);
            return Book::create($data);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            abort(403, 'You do not have permission to create a book.');
        }
    }
}
