<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BookService
{
    public function getAllBooksQuery(array $data): LengthAwarePaginator
    {
        return Book::query()
            ->when(!empty($data['title']), fn($q) =>
                $q->where('books.title', 'like', '%' . $data['title'] . '%'))
            ->when(!empty($data['author']), fn($q) =>
                $q->whereHas('user', fn($query) =>
                    $query->where('name', 'like', '%' . $data['author'] . '%')))
            ->where(
                'status',
                'available',
            )
            ->paginate(20);
    }

    public function createBook(array $data): Book
    {
        try {
            $newBook = Book::create($data);

            return $newBook;
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            abort(403, 'You do not have permission to create a book.');
        }
    }

    public function updateBook(Book $book, array $data): Book
    {
        try {
            $book->update($data);

            return $book;
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            abort(403, 'You do not have permission to update this book.');
        }
    }

    public function deleteBook(Book $book): void
    {
        try {
            $book->delete();
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            abort(403, 'You do not have permission to delete this book.');
        }
    }

    public function getBookById(int $id): ?Book
    {
        return Book::find($id);
    }
}
